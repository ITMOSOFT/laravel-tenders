<?php

namespace ITMOSOFT\Tenders\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use InvalidArgumentException;

class Tender extends Model
{
    protected $table = 'tenders';
    protected $guarded = [];

    protected function casts(): array
    {
        return ['published_at' => 'datetime', 'submission_deadline' => 'datetime', 'closed_at' => 'datetime', 'metadata' => 'array',];
    }


    public function issuer(): MorphTo { return $this->morphTo(); }
    public function submissions(): HasMany { return $this->hasMany(TenderSubmission::class)->orderByDesc('created_at'); }
    public function awardedSubmission(): BelongsTo { return $this->belongsTo(TenderSubmission::class, 'awarded_submission_id'); }



    public function publish(): bool
    {
        if ($this->status !== 'draft') return false;
        if ($this->submission_deadline && $this->submission_deadline->isPast()) return false;
        $this->status = 'published';
        $this->published_at = now();
        return $this->save();
    }

    public function close(): bool
    {
        if ($this->status !== 'published') return false;
        $this->status = 'closed';
        $this->closed_at = now();
        return $this->save();
    }

    public function award(TenderSubmission $submission): bool
    {
        if (! in_array($this->status, ['published', 'closed'], true) || $submission->tender_id !== $this->id || $submission->status !== 'submitted') return false;
        return DB::transaction(function () use ($submission): bool {
            $this->status = 'awarded';
            $this->awarded_submission_id = $submission->id;
            $this->save();
            $submission->status = 'awarded';
            $submission->save();
            return true;
        });
    }

}
