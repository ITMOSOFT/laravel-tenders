<?php
namespace ITMOSOFT\Tenders\Tests\Feature;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use ITMOSOFT\Tenders\Tests\TestCase;
use ITMOSOFT\Tenders\Models\Tender;
use ITMOSOFT\Tenders\Models\TenderSubmission;
class TenderTest extends TestCase
{

    public function test_tender_can_publish_close_and_award_submission(): void
    {
        $tender = Tender::create($this->attributes());
        $this->assertTrue($tender->publish());
        $this->assertTrue($tender->close());
        $submission = TenderSubmission::create(['tender_id' => $tender->id, 'bidder_type' => 'App\Models\User', 'bidder_id' => 5, 'reference' => (string) Str::uuid(), 'amount' => 1200, 'currency' => 'USD', 'status' => 'submitted']);
        $this->assertTrue($tender->fresh()->award($submission));
        $this->assertSame('awarded', $tender->fresh()->status);
        $this->assertSame('awarded', $submission->fresh()->status);
    }

    public function test_tender_rejects_submission_from_another_tender(): void
    {
        $one = Tender::create($this->attributes());
        $two = Tender::create($this->attributes(['title' => 'Second tender']));
        $submission = TenderSubmission::create(['tender_id' => $one->id, 'bidder_type' => 'App\Models\User', 'bidder_id' => 5, 'reference' => (string) Str::uuid(), 'amount' => 10, 'currency' => 'USD', 'status' => 'submitted']);
        $two->publish();
        $this->assertFalse($two->award($submission));
    }


    private function attributes(array $overrides = []): array
    {
        return array_merge(['reference' => (string) Str::uuid(), 'issuer_type' => 'App\Models\User', 'issuer_id' => 1, 'title' => 'Supply of office equipment', 'status' => 'draft'], $overrides);
    }
}
