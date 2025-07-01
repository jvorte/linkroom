<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorite_professionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // χρήστης που κάνει favorite
            $table->foreignId('professional_id')->constrained('users')->onDelete('cascade'); // επαγγελματίας
            $table->timestamps();

            $table->unique(['user_id', 'professional_id']); // για να μην γίνεται διπλό favorite
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorite_professionals');
    }
};
