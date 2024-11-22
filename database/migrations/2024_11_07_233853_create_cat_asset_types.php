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
        Schema::create('cat_asset_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40)->unique();
            $table->unsignedBigInteger('category_id');
            $table->boolean('require_maitenance');
            $table->unsignedBigInteger('frequency_id');
            $table->text('remarks', 255)->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');

            //Constraints
            $table->foreign('category_id')->references('id')->on('cat_asset_categories');
            $table->foreign('frequency_id')->references('id')->on('cat_maintenance_frequencies');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_asset_types');
    }
};