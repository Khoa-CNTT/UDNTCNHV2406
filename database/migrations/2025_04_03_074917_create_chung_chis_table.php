<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chung_chis', function (Blueprint $table) {
            $table->id();
            $table->string('so_hieu_chung_chi');
            $table->integer('id_hoc_vien');
            $table->integer('id_to_chuc');
            $table->string('so_tien');
            $table->string('url_thanh_toan');
            $table->string('file');
            $table->string('token');
            $table->integer('id_tinh_trang');
            $table->string('khoa_hoc');
            $table->string('ngay_cap');
            $table->string('ket_qua');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chung_chis');
    }
};
