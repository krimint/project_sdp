<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use DateTimeInterface;

class Shift extends Model
{
    use HasFactory;

    protected $dates = [
        'waktu_awal',
        'waktu_akhir',
    ];

    protected $fillable = ['user_id','waktu_awal','waktu_akhir','cash_awal','cash_akhir'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('D d M Y');

    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
