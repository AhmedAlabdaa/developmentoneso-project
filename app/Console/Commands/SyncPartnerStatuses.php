<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NewCandidate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SyncPartnerStatuses extends Command
{
    protected $signature = 'sync:partner-statuses';
    protected $description = 'Sync current_status of all candidates to their foreign partners';

    public function handle(): void
    {
        $affected = [];
        $failed   = [];

        NewCandidate::whereNotNull('foreign_partner')
            ->whereNotNull('ref_no')
            ->chunkById(200, function ($candidates) use (&$affected, &$failed) {
                foreach ($candidates as $candidate) {
                    $remoteDb = $this->getForeignDatabaseName($candidate->foreign_partner);

                    if (!$remoteDb) {
                        continue;
                    }

                    try {
                        $rows = DB::connection($remoteDb)
                            ->table('candidates')
                            ->where('ref_no', $candidate->ref_no)
                            ->update(['current_status' => $candidate->current_status]);

                        if ($rows > 0) {
                            $affected[$remoteDb] = ($affected[$remoteDb] ?? 0) + $rows;
                        }
                    } catch (\Throwable $e) {
                        $failed[$remoteDb] = true;
                        Log::error('partner_status_sync_failed', [
                            'db'      => $remoteDb,
                            'ref_no'  => $candidate->ref_no,
                            'message' => $e->getMessage(),
                        ]);
                    }
                }
            });

        foreach (array_unique(array_merge(array_keys($affected), array_keys($failed))) as $db) {
            DB::table('syncstatuses_logs')->insert([
                'partner_db'    => $db,
                'run_result'    => isset($failed[$db]) ? 'failed' : 'success',
                'changes_count' => $affected[$db] ?? 0,
                'run_at'        => now(),
            ]);
        }

        $this->info('Partner statuses synced.');
    }

    protected function getForeignDatabaseName(string $partner): ?string
    {
        return match (strtolower(explode(' ', $partner)[0])) {
            'adey'           => 'adeyonesourceerp_new',
            'alkaba'         => 'alkabaonesourcee_new',
            'bmg'            => 'bmgonesourceerp_new',
            'middleeast'     => 'middleeastonesou_new',
            'my'             => 'myonesourceerp_new',
            'rozana'         => 'rozanaonesourcee_new',
            'tadbeeralebdaa' => 'adbeeralebdaaon_new',
            'vienna'         => 'viennaonesourcee_new',
            'khalid'         => 'khalidonesourcee_new',
            'estella'        => 'estella_new',
            'ritemerit'      => 'ritemeritonesour_new',
            'edith'          => 'edithonesource_new',
            default          => null,
        };
    }
}
