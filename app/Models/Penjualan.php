<?php

namespace App\Models;

use App\Models\ItemPenjualan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';

    protected $primaryKey = 'id_nota';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['tgl', 'kode_pelanggan', 'subtotal'];

    protected $dates = ['tgl', 'created_at', 'updated_at'];

    protected $casts = [
    	'tgl' => 'date:d/m/Y',
    ];

    public function pelanggan()
    {
    	return $this->belongsTo(Pelanggan::class);
    }

    public function itemPenjualan()
    {
    	return $this->hasMany(ItemPenjualan::class, 'nota');
    }
}
