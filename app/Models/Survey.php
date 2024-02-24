<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\DB;

class Survey extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'answer_limit',
        'gender_id',
        'min_age',
        'max_age',
    ];
    
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function answers()
    {
        return $this->hasManyThrough(
            Answer::class,
            Question::class,
            'survey_id',
            'question_id',
            'id',
            'id'
        );
    }
    
    // アンケートを配布したユーザ
    public function delivered_users()
    {
        return $this->belongsToMany(User::class, 'delivered', 'survey_id', 'user_id')->using(Delivered::class);
    }
    
    public function interview_request()
    {
        return $this->hasOne(InterviewRequest::class);
    }
    
    // このアンケートに回答したユーザ
    public function answered_users()
    {
        
        $answers = Answer::with('user')->get();
        $users = [];
        
        foreach($answers as $answer){
            if($answer->survey->is($this)){
                array_push($users, $answer->user);
            }
        }
        return $users;
    }
    
    // Google Form を用いたアンケートかどうか
    public function is_form_survey()
    {
        return !is_null($this->form_id);
    }
    
    // アンケートが、ユーザに配布可能か？
    public function is_allowed_to_deliver($user)
    {
        if ($this->user_id == $user->id) 
        {
            return false;
        }
        // dd($user->profile());
        if ($this->gender_id == $user->profile->gender_id
            && $this->min_age <= $user->profile->age
            && $this->max_age >= $user->profile->age){
            return true;        
        }else{
            return false;
        }
    }
    
    // アンケートの配布
    public function deliver_survey($num) {
        $delivered_num = 0;
        $users = [];
        foreach (User::all() as $user)
        {
            if ($delivered_num >= $num){
                break;
            }
            if ($this->is_allowed_to_deliver($user) && 
                !$this->delivered_users->contains($user)){
                array_push($users, $user->id);
                $delivered_num += 1;
            }
        }
        $this->delivered_users()->attach($users);
        
        return $delivered_num;
    }
    
    // テストユーザにアンケートを配布
    public static function deliver_test($num){
        $user = User::where('email', 'test@gmail.com')->first();;
        
        $i = 0;
        foreach (static::all() as $survey){
            if ($i >= $num){
                break;
            }
            if ($survey->is_allowed_to_deliver($user) &&
                !$survey->delivered_users->contains($user)){
                   $survey->delivered_users()->attach($user->id);
                   $i += 1; 
            }
        }
        return $i;
    }
    
    // あるユーザにアンケートを配る
    public static function deliver_to_user($user){
        foreach (static::all() as $survey){
            if ($survey->is_allowed_to_deliver($user) &&
                !$survey->delivered_users->contains($user)){
                   $survey->delivered_users()->attach($user->id);
                   return true;
            }
        }
        return false;
        
    }
    
    // あるユーザーが作成したアンケート
    public static function created_by_user($user_id)
    {
        return self::where('user_id', $user_id)->get();
    }
    
    // あるユーザーが回答したアンケート
    public static function answered_by_user($user_id)
    {
        return self::whereHas('answers', function (Builder $query) use ($user_id) {
            $query->where('user_id', '=', $user_id);
        })->get();
    }
    
    // ユーザの性別名を返す
    public function gender_name()
    {
         return DB::table('genders')->find($this->gender_id)->name;
    }
    
    
    public function scopeSearch(Builder $query, $params): Builder
    {
        if (isset($params['gender_id'])) $query->where('gender_id', $params['gender_id']);
        
        if (isset($params['min_age'])) $query->where('min_age', '>=', $params['min_age']);
        if (isset($params['max_age'])) $query->where('max_age', '<=', $params['max_age']);
        
        if (isset($params['keyword'])){
            $query->where(function ($query) use ($params) {
                $query->where('title', 'like', '%' . $params['keyword'] . '%')
                    ->orWhere('description', 'like', '%' . $params['keyword'] . '%');
            });
        }
        
        return $query;
    }
    
    // ユーザに、このアンケートについてインタビューを実施したか
    public function is_interviewed_user($user_id)
    {
        $user = User::find($user_id);
        $extra_questions = Question::withoutGlobalScope('extra')
            ->where('survey_id', $this->id)
            ->where('is_extra', true)
            ->get();
    
        foreach ($extra_questions as $question) {
            $answer = $question->answers()->first();
            if ($answer->user->is($user)) {
                return true;
            }
        }
        return false;
    }
    
    // インタビューの結果を問い=>回答の連想配列で返す
    public function get_interview_result($user_id)
    {
        $result = [];
        
        $user = User::find($user_id);
        $extra_questions = Question::withoutGlobalScope('extra')
            ->where('survey_id', $this->id)
            ->where('is_extra', true)
            ->get();
    
        foreach ($extra_questions as $question) {
            $answer = $question->answers()->first();
            if ($answer->user->is($user)) {
                $result[] = array(
                    'question' => $question->body,
                    'answer' => $answer->body,
                );
            }        
        }
        return $result;
    }
}
