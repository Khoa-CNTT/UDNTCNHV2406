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
        Schema::create('co_quan_xac_thucs', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('password');
            $table->string('ten_co_quan');
            $table->string('slug_ten');
            $table->string('hotline');
            $table->string('dia_chi');
            $table->string('ho_ten_nguoi_dai_dien');
            $table->string('so_cccd');
            $table->string('sdt_nguoi_dai_dien');
            $table->string('email_nguoi_dai_dien');
            $table->integer('is_duyet');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('co_quan_xac_thucs');
    }
};
