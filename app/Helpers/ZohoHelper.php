<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZohoHelper
{
    /**
     * Get Zoho Access Token
     *
     * @return string
     * @throws \Exception
     */
    public static function getZohoAccessToken()
    {
        $apiDomain = env('ZOHO_API_DOMAIN', 'https://accounts.zoho.com');
        Log::info('Checking ZOHO_API_DOMAIN', ['ZOHO_API_DOMAIN' => $apiDomain]);

        if (!$apiDomain) {
            throw new \Exception('ZOHO_API_DOMAIN is not set in the environment file.');
        }

        $url = $apiDomain . '/oauth/v2/token';

        $response = Http::asForm()->post($url, [
            'grant_type' => 'refresh_token',
            'client_id' => env('ZOHO_CLIENT_ID'),
            'client_secret' => env('ZOHO_CLIENT_SECRET'),
            'refresh_token' => env('ZOHO_REFRESH_TOKEN'),
        ]);

        Log::info('Zoho Token API Response', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        if ($response->successful()) {
            $responseData = $response->json();

            if (!isset($responseData['access_token'])) {
                Log::error('Access token missing in Zoho API response', ['response' => $responseData]);
                throw new \Exception('Access token missing in Zoho API response.');
            }

            return $responseData['access_token'];
        }

        throw new \Exception('Failed to fetch access token: ' . $response->body());
    }

    /**
     * Create Customer in Zoho CRM
     *
     * @param array $customerData
     * @return array
     * @throws \Exception
     */
    public static function createCustomerInZoho(array $customerData)
    {
        $accessToken = self::getZohoAccessToken();
        $apiDomain = env('ZOHO_API_DOMAIN', 'https://www.zohoapis.com');
        $organizationId = env('ZOHO_ORGANIZATION_ID');
        $url = $apiDomain . '/books/v3/contacts?organization_id=' . $organizationId;

        $response = Http::withToken($accessToken)
            ->post($url, [
                'contact_name' => $customerData['first_name'] . ' ' . $customerData['last_name'],
                'email' => $customerData['email'],
                'phone' => $customerData['mobile'],
                'billing_address' => [
                    'address' => $customerData['address'],
                ],
            ]);

        if ($response->successful()) {
            return $response->json();
        }

        $error = $response->json()['message'] ?? $response->body();
        throw new \Exception('Failed to create customer in Zoho Books: ' . $error);
    }
}
