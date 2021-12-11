<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;

class Paket extends Model
{
    use HasFactory;

    protected $fillable = ['nama','status','harga'];

    public function menu(){
        return $this->belongsToMany(Menu::class,'menu_paket')->withPivot('qty');
    }

}
