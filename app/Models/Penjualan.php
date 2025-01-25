<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $guarded = ['id'];

    public function detail_penjualan()
    {
        return $this->hasMany(DetailPenjualan::class);
    }
}
