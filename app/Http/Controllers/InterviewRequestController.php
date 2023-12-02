<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InterviewRequest;
use App\Models\Survey;

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
}
