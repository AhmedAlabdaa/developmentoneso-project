<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RespondIoService;

class FetchLeads extends Command
{
    protected $signature = 'fetch:leads';
    protected $description = 'Fetch and store leads from Respond.io API';

    protected $respondIoService;

    public function __construct(RespondIoService $respondIoService)
    {
        parent::__construct();
        $this->respondIoService = $respondIoService;
    }

    public function handle()
    {
        $response = $this->respondIoService->fetchAndSaveLeads(50);

        if (isset($response['error'])) {
            $this->error('Error: ' . $response['message']);
        } else {
            $this->info('Leads fetched and saved successfully.');
        }
    }
}
