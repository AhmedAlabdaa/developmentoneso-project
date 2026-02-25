<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZohoCRMService
{
    private string $clientId;
    private string $clientSecret;
    private string $refreshToken;
    private string $accessToken;
    private string $organizationId;

    public function __construct()
    {
        $this->clientId       = env('ZOHO_CLIENT_ID');
        $this->clientSecret   = env('ZOHO_CLIENT_SECRET');
        $this->refreshToken   = env('ZOHO_REFRESH_TOKEN');
        $this->organizationId = env('ZOHO_ORG_ID');
        $this->accessToken    = $this->fetchAccessToken();
    }

    private function fetchAccessToken(): string
    {
        $response = Http::asForm()->post('https://accounts.zoho.com/oauth/v2/token', [
            'grant_type'    => 'refresh_token',
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'refresh_token' => $this->refreshToken,
        ]);

        if ($response->successful() && isset($response->json()['access_token'])) {
            return $response->json()['access_token'];
        }

        throw new Exception('Failed to fetch access token: ' . $response->body());
    }

    private function getBaseUrl(): string
    {
        return env('ZOHO_API_BASE_URL', 'https://www.zohoapis.com') . '/books/v3';
    }

    public function createCustomer(array $customerData): array
    {
        $url = "{$this->getBaseUrl()}/contacts?organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->post($url, $customerData);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to create customer: ' . $response->body());
    }

    public function updateCustomer(string $customerId, array $customerData): array
    {
        $url = "{$this->getBaseUrl()}/contacts/{$customerId}?organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->put($url, $customerData);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to update customer: ' . $response->body());
    }

    public function getCustomer(string $customerId): array
    {
        $url = "{$this->getBaseUrl()}/contacts/{$customerId}?organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->get($url);

        if ($response->successful()) {
            return $response->json()['contact'] ?? [];
        }

        throw new Exception('Failed to retrieve customer: ' . $response->body());
    }

    public function searchCustomerByEmailOrPhone(?string $email, ?string $mobile): ?array
    {
        $url = "{$this->getBaseUrl()}/contacts";
        $criteria = [];

        if ($email) {
            $criteria[] = "email:equals:" . urlencode($email);
        }
        if ($mobile) {
            $criteria[] = "mobile:equals:" . urlencode($mobile);
        }
        $query = implode(' or ', $criteria);

        $response = Http::withToken($this->accessToken)->get($url, [
            'organization_id' => $this->organizationId,
            'criteria'        => $query,
        ]);

        return $response->successful() ? $response->json() : null;
    }

    public function activateCustomer(string $customerId): array
    {
        $url = "{$this->getBaseUrl()}/contacts/{$customerId}/active?organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->post($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to activate customer: ' . $response->body());
    }

    public function deactivateCustomer(string $customerId): array
    {
        $url = "{$this->getBaseUrl()}/contacts/{$customerId}/inactive?organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->post($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to deactivate customer: ' . $response->body());
    }

    public function deleteCustomer(string $customerId): array
    {
        $url = "{$this->getBaseUrl()}/contacts/{$customerId}?organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->delete($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to delete customer: ' . $response->body());
    }

    public function createAddress(string $customerId, array $addressData): array
    {
        $url = "{$this->getBaseUrl()}/contacts/{$customerId}/address?organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->post($url, $addressData);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to create address: ' . $response->body());
    }

    public function listContacts(array $queryParams = []): array
    {
        $url = "{$this->getBaseUrl()}/contacts?organization_id={$this->organizationId}";
        if ($queryParams) {
            $url .= '&' . http_build_query($queryParams);
        }

        $response = Http::withToken($this->accessToken)->get($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to fetch contacts: ' . $response->body());
    }

    public function getContact(string $contactId): array
    {
        $url = "{$this->getBaseUrl()}/contacts/{$contactId}?organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->get($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to retrieve contact: ' . $response->body());
    }

    public function updateContact(string $contactId, array $data): array
    {
        $url = "{$this->getBaseUrl()}/contacts/{$contactId}?organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->put($url, $data);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to update contact: ' . $response->body());
    }

    public function deleteContact(string $contactId): array
    {
        $url = "{$this->getBaseUrl()}/contacts/{$contactId}?organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->delete($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to delete contact: ' . $response->body());
    }

    public function markContactAsActive(string $contactId): array
    {
        $url = "{$this->getBaseUrl()}/contacts/{$contactId}/active?organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->post($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to mark contact active: ' . $response->body());
    }

    public function markContactAsInactive(string $contactId): array
    {
        $url = "{$this->getBaseUrl()}/contacts/{$contactId}/inactive?organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->post($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to mark contact inactive: ' . $response->body());
    }

    public function addContactAddress(string $contactId, array $addressData): array
    {
        $url = "{$this->getBaseUrl()}/contacts/{$contactId}/address?organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->post($url, $addressData);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to add contact address: ' . $response->body());
    }

    public function getContactAddresses(string $contactId): array
    {
        $url = "{$this->getBaseUrl()}/contacts/{$contactId}/address?organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->get($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to retrieve contact addresses: ' . $response->body());
    }

    public function editContactAddress(string $contactId, string $addressId, array $addressData): array
    {
        $url = "{$this->getBaseUrl()}/contacts/{$contactId}/address/{$addressId}?organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->put($url, $addressData);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to edit contact address: ' . $response->body());
    }

    public function deleteContactAddress(string $contactId, string $addressId): array
    {
        $url = "{$this->getBaseUrl()}/contacts/{$contactId}/address/{$addressId}?organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->delete($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to delete contact address: ' . $response->body());
    }

    public function enablePortalAccess(string $contactId, array $contactPersons): array
    {
        $url = "{$this->getBaseUrl()}/contacts/{$contactId}/portal/enable?organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->post($url, ['contact_persons' => $contactPersons]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to enable portal access: ' . $response->body());
    }

    public function enablePaymentReminders(string $contactId): array
    {
        $url = "{$this->getBaseUrl()}/contacts/{$contactId}/paymentreminder/enable?organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->post($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to enable payment reminders: ' . $response->body());
    }

    public function disablePaymentReminders(string $contactId): array
    {
        $url = "{$this->getBaseUrl()}/contacts/{$contactId}/paymentreminder/disable?organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->post($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to disable payment reminders: ' . $response->body());
    }

    public function checkCustomFieldExists(string $fieldName): bool
    {
        $url = "{$this->getBaseUrl()}/settings/fields?module=contacts&organization_id={$this->organizationId}";
        $response = Http::withToken($this->accessToken)->get($url);

        if ($response->successful()) {
            foreach ($response->json()['fields'] ?? [] as $field) {
                if (($field['label'] ?? '') === $fieldName) {
                    return true;
                }
            }
        }

        Log::error('Failed to fetch custom fields or field not found', [
            'status' => $response->status(),
            'body'   => $response->body(),
        ]);

        return false;
    }
}
