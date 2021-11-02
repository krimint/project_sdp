<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MenuPaket extends Pivot
{
    protected $fillable = ['paket_id','menu_id'];
}
