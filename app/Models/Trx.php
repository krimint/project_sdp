<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetailTrx;
use App\Models\Meja;

class Trx extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function detailTrx(){
        return $this->hasMany(DetailTrx::class);
    }

    public function meja(){
        return $this->belongsTo(Meja::class);
    }
}
