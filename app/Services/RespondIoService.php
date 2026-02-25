<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Lead;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RespondIoService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl = 'https://api.respond.io/v2/contact/list';

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('RESPOND_IO_API_KEY');
    }

    public function fetchAndSaveLast7DaysLeads()
    {
        $cursorId = null;
        $totalFetched = 0;

        do {
            $response = $this->fetchLeadsFromApi($cursorId);
            if (isset($response['error'])) {
                Log::error('Respond.io API Error: ' . $response['message']);
                return ['error' => true, 'message' => $response['message']];
            }

            $batchSize = count($response['items'] ?? []);
            $this->saveLeadsToDatabase($response['items'] ?? []);
            $totalFetched += $batchSize;
            $cursorId = $response['cursorId'] ?? null;
        } while ($cursorId);

        return ['success' => true, 'message' => "$totalFetched leads fetched and saved successfully."];
    }

    private function fetchLeadsFromApi($cursorId = null)
    {
        try {
            $startTime = Carbon::now()->subDays(7)->timestamp;

            $body = [
                'search'   => '',
                'filter'   => [
                    '$and' => [
                        ['created_at' => ['$gte' => $startTime]]
                    ]
                ],
                'limit'    => 100,
                'timezone' => 'Asia/Dubai',
            ];

            if ($cursorId) {
                $body['cursorId'] = $cursorId;
            }

            $response = $this->client->post($this->baseUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type'  => 'application/json',
                ],
                'json' => $body
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return ['error' => true, 'message' => 'API Request Failed: ' . $e->getMessage()];
        }
    }

    private function saveLeadsToDatabase(array $leads)
    {
        $existingRespondIds = Lead::pluck('respond_id')->toArray();
        $leadData = [];

        foreach ($leads as $lead) {
            if (!in_array($lead['id'] ?? null, $existingRespondIds)) {
                $createdAt = isset($lead['created_at']) 
                    ? Carbon::createFromTimestamp($lead['created_at'])->format('Y-m-d H:i:s') 
                    : now();

                $leadData[] = [
                    'respond_id'      => $lead['id'] ?? null,
                    'first_name'      => $lead['firstName'] ?? '',
                    'last_name'       => $lead['lastName'] ?? '',
                    'email'           => $lead['email'] ?? null,
                    'phone'           => $lead['phone'] ?? null,
                    'sales_name'      => $lead['assignee']['firstName'] ?? null,
                    'sales_email'     => $lead['assignee']['email'] ?? null,
                    'source'          => $lead['source'] ?? null,
                    'status'          => $lead['status'] ?? null,
                    'status_date_time'=> $createdAt,
                    'package'         => $lead['package'] ?? null,
                    'nationality'     => $lead['nationality'] ?? null,
                    'negotiation'     => $lead['negotiation'] ?? null,
                    'lifecycle'       => $lead['lifecycle'] ?? null,
                    'notes'           => $lead['notes'] ?? null,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ];
            }
        }

        if (!empty($leadData)) {
            DB::table('leads')->insert($leadData);
            Log::info("Inserted " . count($leadData) . " new leads.");
        }
    }
}
