<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','waktu_awal','waktu_akhir','cash_awal','cash_akhir'];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
