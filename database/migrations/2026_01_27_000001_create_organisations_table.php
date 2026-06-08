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
        Schema::create('organisations', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('website')->nullable();
            $table->string('steam_group_url')->nullable();
            $table->longText('blurb')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('use_favicon')->default(false);
            $table->boolean('refetch_favicon')->default(false);
            $table->boolean('valid_banner')->default(false);
            $table->timestamp('assumed_stale_at')->nullable();
            $table->string('lpps_url', 512)->nullable();
            $table->dateTime('lpps_last_fetched_at')->nullable();
            $table->boolean('lpps_crawl_successful')->nullable();
            $table->string('lpps_crawl_result', 1024)->nullable();
            $table->boolean('lpps_disabled')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('organisation_members', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('organisation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['organisation_id', 'user_id']);
        });

        Schema::create('organisation_invitations', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->string('code', 64)->unique();
            $table->foreignId('organisation_id')->constrained()->cascadeOnDelete();
            $table->string('email');
            $table->string('role');
            $table->foreignId('invited_by')->constrained('users')->cascadeOnDelete();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisation_invitations');
        Schema::dropIfExists('organisation_members');
        Schema::dropIfExists('organisations');
    }
};
