<?php

namespace App\Models;

use App\Models\ItemPenjualan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $primaryKey = 'kode';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['nama', 'kategori', 'harga'];

    protected $dates = ['created_at', 'updated_at'];

    public function itemPenjualan()
    {
    	return $this->hasMany(ItemPenjualan::class, 'kode_barang');
    }
}
