<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Trx;

class DetailTrx extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function trx(){
        return $this->belongsTo(Trx::class);
    }
}
