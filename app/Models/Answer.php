<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Question;

class Answer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'body'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    
    public function survey()
    {
        return $this->hasOneThrough(
            Survey::class, 
            Question::class,
            'id',
            'id',
            'question_id',
            'survey_id',
        );
        
    }
    
    public static function get_answers($user, $survey)
    {
        $answers = self::with('user', 'survey', 'question')->get();
        
        return $answers->filter(function ($answer) use ($user, $survey) {
            return $answer->question && $answer->question->is_extra == false 
                && $answer->user->is($user) && $answer->survey->is($survey);
        });
    }
    
    public static function answers_by_user($survey)
    {
        $result = [];
        foreach ($survey->answered_users() as $user){
            $result[$user->id] = self::get_answers($user, $survey);
        }
        return $result;
    }
}
