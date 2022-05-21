<?php

namespace App\Models;

use App\Models\Penjualan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';

    protected $primaryKey = 'id_pelanggan';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['nama', 'domisili', 'jenis_kelamin'];

    protected $dates = ['created_at', 'updated_at'];

    public function penjualan()
    {
    	return $this->hasMany(Penjualan::class);
    }
}
