<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('job_listings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('company_id')->constrained('companies')->onDelete('cascade'); 
        $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); 
        $table->string('title');
        $table->text('description');
        $table->decimal('salary')->nullable();
        $table->enum('location', ['remote', 'in_company'])->default('in_company'); 
        $table->string('working_hours')->nullable();
        $table->string('experience')->nullable();
        $table->string('job_title');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
