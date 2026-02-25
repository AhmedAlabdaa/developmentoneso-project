<?php

namespace App\Services\ReturnMaid;

use App\Enum\AmReturnAction;
use App\Enum\GeneralStatus;
use App\Models\AmReturnMaid;
use App\Models\Amp3ActionNotify;
use Exception;
use Illuminate\Support\Facades\Schema;

class RefundActionService
{
    private const RETURN_MAID_RELATIONS = [
        'contractMovment.primaryContract.crm',
        'contractMovment.employee',
    ];

    private const ACTION_NOTIFY_RELATIONS = [
        'movementContract.primaryContract.crm',
        'movementContract.employee',
    ];

    public function raiseRefundByReturnMaidId(int $id, int $action, array $data = []): AmReturnMaid
    {
        $this->assertRefundAction($action);

        $returnMaid = AmReturnMaid::findOrFail($id);
        $actionChanged = $this->applyRefundAction($returnMaid);

        if ($actionChanged) {
            $this->createOrUpdateRefundNotify($returnMaid, $this->buildRefundPayload($data));
        }

        return $returnMaid->refresh()->load(self::RETURN_MAID_RELATIONS);
    }

    public function raiseRefund(array $data): Amp3ActionNotify
    {
        $returnMaid = AmReturnMaid::query()
            ->where('am_movment_id', $data['am_contract_movement_id'])
            ->latest('id')
            ->firstOrFail();

        $this->applyRefundAction($returnMaid);

        return $this->createOrUpdateRefundNotify($returnMaid, $this->buildRefundPayload($data));
    }

    public function updateActionNotify(Amp3ActionNotify $actionNotify, array $data): Amp3ActionNotify
    {
        $actionNotify->update(array_merge($data, [
            'updated_by' => auth()->id(),
        ]));

        return $actionNotify->refresh()->load(self::ACTION_NOTIFY_RELATIONS);
    }

    public function deleteActionNotify(Amp3ActionNotify $actionNotify): bool
    {
        return (bool) $actionNotify->delete();
    }

    private function createOrUpdateRefundNotify(AmReturnMaid $returnMaid, array $refundData): Amp3ActionNotify
    {
        $existing = Amp3ActionNotify::query()
            ->where('am_contract_movement_id', $returnMaid->am_movment_id)
            ->where('status', GeneralStatus::PENDING)
            ->first();

        if ($existing) {
            return $this->updateActionNotify($existing, [
                'amount' => $refundData['amount'],
                'note' => $refundData['note'],
                'refund_date' => $refundData['refund_date'],
            ]);
        }

        $actionNotify = Amp3ActionNotify::create([
            'am_contract_movement_id' => $returnMaid->am_movment_id,
            'amount' => $refundData['amount'],
            'note' => $refundData['note'] ?? null,
            'refund_date' => $refundData['refund_date'] ?? null,
            'status' => GeneralStatus::PENDING,
            'created_by' => auth()->id(),
        ]);

        return $actionNotify->refresh()->load(self::ACTION_NOTIFY_RELATIONS);
    }

    private function applyRefundAction(AmReturnMaid $returnMaid): bool
    {
        $oldAction = $returnMaid->action?->value;
        $returnMaid->action = AmReturnAction::RefundRaised->value;
        $returnMaid->saveOrFail();

        if (Schema::hasColumn($returnMaid->getTable(), 'action_status')) {
            $returnMaid->newQuery()
                ->whereKey($returnMaid->id)
                ->update(['action_status' => AmReturnAction::RefundRaised->value]);
        }

        return $oldAction !== AmReturnAction::RefundRaised->value;
    }

    private function assertRefundAction(int $action): void
    {
        if ($action !== AmReturnAction::RefundRaised->value) {
            throw new Exception('This action endpoint is dedicated to Raise Refund only.');
        }
    }

    private function buildRefundPayload(array $data): array
    {
        return [
            'amount' => $data['amount'] ?? null,
            'note' => $data['note'] ?? null,
            'refund_date' => $data['refund_date'] ?? null,
        ];
    }
}

