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
        Schema::create('org_departments', function (Blueprint $table) {
            $table->id();
            $table->string('internal_id', 6)->unique();
            $table->string('name', 25);
            $table->timestamps();
            $table->string('created_by', 50);
            $table->string('updated_by', 50);  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_departments');
    }
};
