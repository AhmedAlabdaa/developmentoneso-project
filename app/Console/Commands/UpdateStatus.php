<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class UpdateStatus extends Command
{
    protected $signature = 'update:status';
    protected $description = 'Update current_status to 1 if current_status is 3 and hold_date is greater than 6 hours';
    public function handle()
    {
        Log::info('UpdateStatus command started.');
        $thresholdTime = Carbon::now('Asia/Qatar')->subHours(6); 
        try {
            $candidates = DB::table('new_candidates')
                ->where('current_status', 3)
                ->where('hold_date', '<', $thresholdTime)
                ->get();
            if ($candidates->isEmpty()) {
                $this->info('No candidates found for update.');
                Log::info('No candidates found for update.');
                return 0;
            }
            foreach ($candidates as $candidate) {
                DB::table('new_candidates')
                    ->where('id', $candidate->id)
                    ->update([
                        'current_status' => 1,
                        'updated_at' => Carbon::now('Asia/Qatar'),
                    ]);
                Log::info("Updated local database: Candidate ID {$candidate->id}");
                try {
                    $foreignPartner = DB::table('new_candidates')
                        ->where('id', $candidate->id)
                        ->value('foreign_partner');
                    
                    if ($foreignPartner) {
                        $firstWord = strtolower(explode(' ', trim($foreignPartner))[0]);
                        $databaseMapping = [
                            'adey' => 'adeyonesourceerp_new',
                            'bmg' => 'bmgonesourceerp_new',
                            'alkaba' => 'alkabaonesourcee_new',
                            'my' => 'myonesourceerp_new'
                        ];
                        
                        $databaseName = $databaseMapping[$firstWord] ?? null;
                        if ($databaseName) {
                            DB::connection($databaseName)
                                ->table('candidates')
                                ->where('ref_no', $candidate->ref_no)
                                ->update([
                                    'current_status' => 1,
                                    'updated_at' => Carbon::now('Africa/Addis_Ababa'),  
                                ]);
                            Log::info("Updated remote database ({$databaseName}): Candidate Ref No {$candidate->ref_no}");
                        } else {
                            Log::warning("No matching database found for Candidate Ref No {$candidate->ref_no} with foreign partner: {$foreignPartner}");
                        }
                    } else {
                        Log::warning("Foreign partner not found for Candidate Ref No {$candidate->ref_no}");
                    }
                } catch (\Exception $e) {
                    Log::error("Failed to update remote database for Candidate Ref No {$candidate->ref_no}: " . $e->getMessage());
                }
            }
            $this->info('Statuses updated successfully.');
            Log::info('UpdateStatus command completed successfully.');
        } catch (\Exception $e) {
            $this->error('An error occurred.');
            Log::error('Error in UpdateStatus command: ' . $e->getMessage());
        }
        return 0;
    }
}
