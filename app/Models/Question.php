<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Survey;
use App\Models\Answer;


class Question extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'body',
    ];
    
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
    
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
