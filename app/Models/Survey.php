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
    
    public function delivered_users()
    {
        return $this->belongsToMany(User::class, 'delivered', 'survey_id', 'user_id')->using(Delivered::class);
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
        
        if (isset($params['min_age'])) $query->where('min_age', '<=', $params['min_age']);
        if (isset($params['max_age'])) $query->where('max_age', '>=', $params['max_age']);
        
        if (isset($params['keyword'])){
            $query->where(function ($query) use ($params) {
                $query->where('title', 'like', '%' . $params['keyword'] . '%')
                    ->orWhere('description', 'like', '%' . $params['keyword'] . '%');
            });
        }
        
        return $query;
    }
}
