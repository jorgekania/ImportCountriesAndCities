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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();

            $table->string("name", 150)->nullable()->comment("Nome do país");
            $table->string("official_name", 150)->nullable()->comment("nome oficial do país");
            $table->string("acronym", 5)->nullable()->comment("sigla do país");
            $table->string("idd_root", 5)->nullable()->comment("ddi");
            $table->string("idd_suffixes", 10)->nullable()->comment("ddi sufixo");
            $table->string("capital", 150)->nullable()->comment("Capital do país");
            $table->string("region", 200)->nullable()->comment("região que pertence o país");
            $table->string("sub_region", 200)->nullable()->comment("sub região que pertence o país");
            $table->string("start_of_week", 10)->nullable()->comment("semana começa em");
            $table->jsonb("language", 200)->nullable()->comment("idioma do país");
            $table->jsonb("timezone")->nullable()->comment("timezones do país");
            $table->jsonb("continents", 200)->nullable()->comment("continentes que pertence o país");
            $table->jsonb("flags", 200)->nullable()->comment("bandeiras o país");
            $table->jsonb("zip_code", 200)->nullable()->comment("formatação do código postal país");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
