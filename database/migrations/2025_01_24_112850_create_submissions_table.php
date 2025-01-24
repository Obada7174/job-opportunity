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
    Schema::create('submissions', function (Blueprint $table) {
        $table->id(); 
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
        $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade'); 
        $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
        $table->timestamp('applied_at')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
