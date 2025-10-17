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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->date('birth_date');
            $table->string('country', 2);
            $table->string('city');
            $table->string('address');
            $table->string('postal_code');
            $table->text('notes')->nullable();
            $table->decimal('total', 10, 2);
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'cancelled',
            ])->default('pending')->index();
            $table->enum('client_type', ['natural', 'legal'])->default('natural')->index();
            $table->string('company_name')->nullable();
            $table->string('company_cui')->nullable();
            $table->string('company_reg')->nullable();
            $table->string('company_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};