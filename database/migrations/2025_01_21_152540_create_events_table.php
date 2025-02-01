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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->nullable()->constrainted('users');
            $table->foreignId('organiser_id')->constrained('organisers');
            $table->foreignId('venue_id')->constrained('venues');
            $table->string('title');
            $table->string('slug')->unique();
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->longText('blurb')->nullable();
            $table->text('website')->nullable();
            $table->text('image_url')->nullable();
            $table->float('price_on_door', 2)->nullable();
            $table->float('price_in_adv', 2)->nullable();
            $table->string('currency')->nullable();
            $table->string('alcohol')->nullable();
            $table->string('smoking')->nullable();
            $table->string('showers')->nullable();
            $table->integer('seats')->nullable();
            $table->integer('network_mbps')->nullable();
            $table->integer('internet_mbps')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
