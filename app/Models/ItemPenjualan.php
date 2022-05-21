<?php

namespace App\Models;

use App\Models\Barang;
use App\Models\Penjualan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPenjualan extends Model
{
    use HasFactory;

    protected $table = 'item_penjualan';

    public $incrementing = false;

    protected $fillable = ['nota', 'kode_barang', 'qty'];

    protected $dates = ['created_at', 'updated_at'];

    public function penjualan()
    {
    	return $this->belongsTo(Penjualan::class, "nota");
    }

    public function barang()
    {
    	return $this->belongsTo(Barang::class, 'kode_barang');
    }

    public static function scopeItem($query, $nota, $kodeBarang)
    {
    	return $query->where('nota', $nota)->where('kode_barang', $kodeBarang);
    }
}
