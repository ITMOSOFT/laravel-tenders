<?php
namespace ITMOSOFT\Tenders\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
class TenderSubmission extends Model {
 protected $table='tender_submissions'; protected $guarded=[];
 protected function casts(): array { return ['amount'=>'decimal:2','evaluation_score'=>'decimal:2']; }
 public function tender(): BelongsTo { return $this->belongsTo(Tender::class); }
 public function bidder(): MorphTo { return $this->morphTo(); }
}
