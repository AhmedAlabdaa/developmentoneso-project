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
        Schema::table('am_primary_contracts', function (Blueprint $table) {
            $table->string('serial_no', 20)->nullable()->after('id');
        });

        Schema::table('am_contract_movments', function (Blueprint $table) {
            $table->string('serial_no', 30)->nullable()->after('id');
        });

        DB::transaction(function (): void {
            $contracts = DB::table('am_primary_contracts')
                ->select('id', 'serial_no')
                ->orderBy('id')
                ->get();

            $contractSequence = 0;

            foreach ($contracts as $contract) {
                $contractSequence++;

                if (!empty($contract->serial_no)) {
                    continue;
                }

                DB::table('am_primary_contracts')
                    ->where('id', $contract->id)
                    ->update([
                        'serial_no' => 'CT-' . str_pad((string) $contractSequence, 4, '0', STR_PAD_LEFT),
                    ]);
            }

            $contractSerials = DB::table('am_primary_contracts')
                ->select('id', 'serial_no')
                ->get()
                ->keyBy('id');

            $movements = DB::table('am_contract_movments')
                ->select('id', 'am_contract_id', 'serial_no')
                ->orderBy('am_contract_id')
                ->orderBy('id')
                ->get();

            $sequences = [];

            foreach ($movements as $movement) {
                if (!array_key_exists($movement->am_contract_id, $sequences)) {
                    $sequences[$movement->am_contract_id] = 0;
                }

                $sequences[$movement->am_contract_id]++;

                if (!empty($movement->serial_no)) {
                    continue;
                }

                $contractSerial = data_get($contractSerials, $movement->am_contract_id . '.serial_no')
                    ?: 'CT-' . str_pad((string) $movement->am_contract_id, 4, '0', STR_PAD_LEFT);

                DB::table('am_contract_movments')
                    ->where('id', $movement->id)
                    ->update([
                        'serial_no' => $contractSerial . '-' . $sequences[$movement->am_contract_id],
                    ]);
            }
        });

        Schema::table('am_primary_contracts', function (Blueprint $table) {
            $table->unique('serial_no');
        });

        Schema::table('am_contract_movments', function (Blueprint $table) {
            $table->unique('serial_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('am_contract_movments', function (Blueprint $table) {
            $table->dropUnique(['serial_no']);
            $table->dropColumn('serial_no');
        });

        Schema::table('am_primary_contracts', function (Blueprint $table) {
            $table->dropUnique(['serial_no']);
            $table->dropColumn('serial_no');
        });
    }
};
