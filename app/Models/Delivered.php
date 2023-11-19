<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Delivered extends Pivot
{
    use HasFactory;
    
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
    
    // public function survey()
    // {
    //     return $this->belongsTo(Survey::class);
    // }
}
