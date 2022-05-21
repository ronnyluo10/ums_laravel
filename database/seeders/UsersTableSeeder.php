<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create();
    	$token = $user->createToken(env('SANCTUM_DEFAULT_NAME'), [
    		'pelanggan:read', 'pelanggan:create', 'pelanggan:update', 'pelanggan:delete',
    		'barang:read', 'barang:create', 'barang:update', 'barang:delete',
    		'penjualan:read', 'penjualan:create', 'penjualan:update', 'penjualan:delete',
    		'item_penjualan:read', 'item_penjualan:create', 'item_penjualan:update', 'item_penjualan:delete',
    	]);

    	dd($token->plainTextToken);
    }
}
