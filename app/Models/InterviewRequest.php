<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewRequest extends Model
{
    use HasFactory;
    
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
    
    public function requested_user()
    {
        return $this->belongsTo(User::class, 'requested_user_id');
    }
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
    // インタビューを受け入れる
    public function accept()
    {
        if ($this->accepted == true){
            return false;
        }
        
        $this->accepted = true;
        $this->save();
        return true;
    }
    
    // 引数にとったユーザーが、インタビューをリクエストされているか？
    public function is_requested_user($user)
    {
        
        if ($user->is($this->requested_user)){
            return true;
        }else{
            return false;
        }
    }
}
