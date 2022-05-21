<?php

return [
    \App\Library\Repository\Pelanggan\PelangganRepository::class => [
    	\App\Http\Controllers\Data\PelangganController::class,
    ],

    \App\Library\Repository\Barang\BarangRepository::class => [
    	\App\Http\Controllers\Data\BarangController::class,
    ],

    \App\Library\Repository\Penjualan\PenjualanRepository::class => [
    	\App\Http\Controllers\Data\PenjualanController::class,
    ],

    \App\Library\Repository\Penjualan\ItemPenjualanRepository::class => [
    	\App\Http\Controllers\Data\ItemPenjualanController::class,
    ]
];