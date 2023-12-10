<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InterviewRequest;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Post;

class InterviewRequestController extends Controller
{
    //
    public function request(Survey $survey, Request $request)
    {
        // dd($survey->interview_request);
        if(isset($survey->interview_request)){
            // すでにアンケートについて他のユーザにリクエストをしている状態なら
            session()->flash('flash_message', 'すでにリクエストをしています');
        }else{
            $interview_request = new InterviewRequest;
            $interview_request->request_user_id = $survey->user->id;
            $interview_request->requested_user_id = $request['requested_user'];
            $survey->interview_request()->save($interview_request);
            
            session()->flash('flash_message', '{$survey->title}のインタビューをリクエストしました');
        }
        
        return redirect()->back();
    }
    
    public function accept(Survey $survey, Request $request)
    {
        if($survey->interview_request->accept()){
            session()->flash('flash_message', 'インタビューのリクエストを受け入れました。');
        }else{
            session()->flash('flash_message', 'リクエストの受け入れに失敗しました。');
            
        }
        
        return redirect('/interviews/{$survey->id}');
    }
    
    // インタビュー部屋を表示する
    public function show(Survey $survey, Request $request)
    {
        $posts = $survey->interview_request->posts;
        return view('interviews.show', [
            'user' => $request->user,
            'posts' => $posts,
            'survey' => $survey,
        ]);
    }
    
    // 投稿の保存
    public function create(Survey $survey, Request $request)
    {
        $interview_request = $survey->interview_request;
        $post = new Post();
        $post->body = $request['body'];
        $post->user_id = $request->user()->id;
        
        $interview_request->posts()->save($post);
        // dd($post);
        return redirect("/interviews/{$survey->id}");
    }
    
    public function select(Survey $survey, Request $request)
    {
        return view('interviews.select', [
            'user' => $request->user,
            'survey' => $survey,
            'posts' => $survey->interview_request->posts,    
        ]);
    }
    
    public function store(Survey $survey, Request $request)
    {
        DB::transaction(function () use($request, $survey) {
            $question = new Question();
            $question->body = $request['question'];
            $question->is_extra = true;
            $survey->questions()->save($question);
            
            $answer = new Answer();
            $answer->body = $request['answer'];
            $answer->user_id = $survey->interview_request->requested_user_id;
            
            $question->refresh()->answers()->save($answer);
            
        }, 5);
        
        return redirect()->back();
    }
    
    // インタビュー部屋での投稿をjsonで取得
    public function show_all(Survey $survey, Request $request)
    {
        $posts = $survey->interview_request->posts;
        $posts_array = array();
        
        foreach ($posts as $post){
            $posts_array[] = array(
                'id' => $post->id, 
                'user_name' => $post->user->name,
                'body' => $post->body,
                'is_logged_user' => $post->user->is($request->user) ? true : false,
            );
        }
        
        return response()->json($posts_array);
    }
}
