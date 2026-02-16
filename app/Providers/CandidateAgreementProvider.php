<?php
namespace App\Providers;

use Illuminate\Support\Facades\DB;

class CandidateAgreementProvider
{
    public static function getLatestAgreementForCandidate($candidateId)
    {
        return DB::table('agreements')
            ->where('candidate_id', $candidateId)
            ->orderByDesc('created_at')
            ->first();
    }
}

