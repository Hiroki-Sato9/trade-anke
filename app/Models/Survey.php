<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    
    // あるユーザーが作成したアンケート
    public static function created_by_user($user_id)
    {
        return self::where('user_id', $user_id)->get();
    }
}
