<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_penjualan', function (Blueprint $table) {
            $table->string('nota', 15);
            $table->string('kode_barang', 10);
            $table->mediumInteger('qty');
            $table->timestamps();

            $table->foreign('nota')->references('id_nota')->on('penjualan')->onDelete('cascade');
            $table->foreign('kode_barang')->references('kode')->on('barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_penjualan');
    }
};
