<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Profile extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'gender_id',
        'age',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function add_point($point)
    {
        if ($this->point + $point < 1){
            return false;
        }
        
        $this->point += $point;
        $this->save();
        session()->flash('flash_message', "ポイントが変動しました");
    }
}
