<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Lead;

class RespondIoWebhookController extends Controller
{
    private $validKeys = [
        'poI93NRK9BnfHk/KCSCPkK+3pcV6rZTY/3oe4GPG4lM=',
        'btdw/PWAeB6ewyq/Mb0D3PHJ760JK6iJ/HQ572Ay844=',
        'Y7dkCzHFixZIpSyMSQHIk/GLyIao2BgAOD1QBeXjrzU=',
        'W5nGilZWKK+WPIstbt4yMqACTdtMmCi3z735t5ETAgc='
    ];

    public function handleWebhook(Request $request)
    {
        try {
            $rawContent = $request->getContent();
            $receivedSignature = $request->header('X-Webhook-Signature', '');
            if (!$this->verifyWebhookSignature($receivedSignature, $rawContent)) {
                return response()->json([
                    'message'  => 'Invalid signature',
                    'received' => $receivedSignature
                ], 400);
            }
            $payload = json_decode($rawContent, true);
            if (!is_array($payload)) {
                return response()->json(['message' => 'No valid payload'], 400);
            }
            $eventType = $payload['event_type'] ?? '';
            $contact = $payload['contact'] ?? null;
            if (!$contact || empty($contact['phone'])) {
                return response()->json(['message' => 'No valid phone in contact data'], 400);
            }
            $lead = Lead::where('phone', $contact['phone'])->first();
            $createdAt = isset($contact['created_at'])
                ? Carbon::createFromTimestamp($contact['created_at'])->format('Y-m-d H:i:s')
                : now()->format('Y-m-d H:i:s');
            if (!$lead) {
                $lead = new Lead();
                $lead->phone = $contact['phone'];
            }
            switch ($eventType) {
                case 'contact.created':
                case 'contact.updated':
                case 'contact.assignee.updated':
                case 'contact.lifecycle.updated':
                default:
                    $this->fillLeadData($lead, $contact, $createdAt, $payload);
                    break;
            }
            $lead->save();
            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            Log::error('Respond.io Webhook Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    private function verifyWebhookSignature(string $receivedSignature, string $rawPayload): bool
    {
        foreach ($this->validKeys as $key) {
            $expectedSignature = base64_encode(hash_hmac('sha256', $rawPayload, $key, true));
            Log::debug('Signature check', [
                'expected' => $expectedSignature,
                'received' => $receivedSignature,
            ]);
            if (hash_equals($expectedSignature, $receivedSignature)) {
                return true;
            }
        }
        return false;
    }

    private function fillLeadData(Lead $lead, array $contact, string $createdAt, array $payload): void
    {
        $lead->respond_id       = $contact['id'] ?? null;
        $lead->first_name       = $contact['firstName'] ?? '';
        $lead->last_name        = $contact['lastName'] ?? '';
        $lead->phone            = $contact['phone'] ?? $lead->phone;
        $lead->email            = $contact['email'] ?? null;
        $lead->sales_name       = $contact['assignee']['firstName'] ?? null;
        $lead->sales_email      = $contact['assignee']['email'] ?? null;
        $lead->source           = 'respond.io';
        $lead->status           = $contact['status'] ?? null;
        $lead->status_date_time = $createdAt;
        $lead->lifecycle        = $contact['lifecycle'] ?? null;
        $lead->notes            = null;
        $lead->nationality      = null;
        $lead->negotiation      = null;
    }
}
