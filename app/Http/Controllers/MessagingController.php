<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RespondIoService;

class MessagingController extends Controller
{
    protected $respondIoService;

    public function __construct(RespondIoService $respondIoService)
    {
        $this->respondIoService = $respondIoService;
    }

    /**
     * Send a message via respond.io.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'channel_id' => 'required|string',
            'contact_id' => 'required|string',
            'message'    => 'required|string',
        ]);

        $channelId = $request->input('channel_id');
        $contactId = $request->input('contact_id');
        $message   = $request->input('message');

        $response = $this->respondIoService->sendMessage($channelId, $contactId, $message);
        return response()->json($response);
    }
}
