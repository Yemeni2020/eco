<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_gateway_settings', function (Blueprint $table) {
            $table->id();
            $table->string('gateway')->unique();
            $table->boolean('is_enabled')->default(false);
            $table->string('display_name')->nullable();
            $table->json('credentials')->nullable();
            $table->boolean('sandbox_mode')->default(true);
            $table->timestamps();
        });

        DB::table('payment_gateway_settings')->insertOrIgnore([
            ['gateway' => 'mada', 'display_name' => 'Mada', 'sandbox_mode' => true, 'created_at' => now(), 'updated_at' => now()],
            ['gateway' => 'stcpay', 'display_name' => 'STC Pay', 'sandbox_mode' => true, 'created_at' => now(), 'updated_at' => now()],
            ['gateway' => 'applepay', 'display_name' => 'Apple Pay', 'sandbox_mode' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateway_settings');
    }
};
