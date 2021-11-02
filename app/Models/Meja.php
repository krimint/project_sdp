<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Trx;

class Meja extends Model
{
    use HasFactory;

    protected $fillable = ['nama','status']; 

    public function trx(){
        return $this->hasOne(Trx::class);
    }
}
