<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paket;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['nama','status','harga','kategori'];

    public function paket(){
        return $this->belongsToMany(Paket::class,'menu_paket');
    }
    
}
