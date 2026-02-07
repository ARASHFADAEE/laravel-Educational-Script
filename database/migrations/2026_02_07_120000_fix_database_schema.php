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
        // Fix courses table
        Schema::table('courses', function (Blueprint $table) {
            // Using decimal for prices is generally safer than integer if cents are involved, 
            // but for Toman/Rial usually integer is fine. 
            // Given the user didn't specify, I'll use unsignedBigInteger as it fits 'price' usually in Iran.
            $table->unsignedBigInteger('regular_price')->change();
            $table->unsignedBigInteger('sale_price')->nullable()->change();
        });

        // Fix enrollments table
        Schema::table('enrollments', function (Blueprint $table) {
             $table->unsignedBigInteger('price')->change();
        });

        // Fix payments table
        Schema::table('payments', function (Blueprint $table) {
             $table->unsignedBigInteger('amount')->change();
        });

        // Fix lessons table
        Schema::table('lessons', function (Blueprint $table) {
             $table->renameColumn('File_link', 'file_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('regular_price')->change();
            $table->string('sale_price')->nullable()->change();
        });

        Schema::table('enrollments', function (Blueprint $table) {
             $table->string('price')->change();
        });

        Schema::table('payments', function (Blueprint $table) {
             $table->string('amount')->change();
        });

        Schema::table('lessons', function (Blueprint $table) {
             $table->renameColumn('file_link', 'File_link');
        });
    }
};
