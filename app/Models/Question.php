<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Survey;
use App\Models\Answer;


class Question extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'body',
    ];
    
    protected $casts = [
        'is_extra' => 'boolean',
    ];
    
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
    
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    
    // グローバルスコープの適用
    public static function booted()
    {
        static::addGlobalScope('extra', function (Builder $builder) {
            $builder->where('is_extra', '=', false);
        });
    }
}
