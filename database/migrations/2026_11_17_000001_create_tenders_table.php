<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenders', function (Blueprint $table): void {
            $table->id();
$table->uuid('reference')->unique();
            $table->morphs('issuer');
            $table->string('title');
            $table->longText('scope')->nullable();
            $table->string('status')->default('draft')->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('submission_deadline')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->foreignId('awarded_submission_id')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('tender_submissions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tender_id')->constrained('tenders')->cascadeOnDelete();
            $table->morphs('bidder');
            $table->uuid('reference')->unique();
            $table->longText('proposal')->nullable();
            $table->decimal('amount', 14, 2);
            $table->string('currency', 3)->default('USD');
            $table->decimal('evaluation_score', 8, 2)->nullable();
            $table->string('status')->default('submitted')->index();
            $table->text('evaluation_notes')->nullable();
            $table->timestamps();
        });

    }

    public function down(): void
    {
Schema::dropIfExists('tender_submissions');
        Schema::dropIfExists('tenders');
    }
};
