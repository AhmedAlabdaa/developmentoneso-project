<?php

namespace Tests\Feature;

use App\Models\AmPrimaryContract;
use App\Models\CRM;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AmMonthlyContractApiTest extends TestCase
{
    use RefreshDatabase;

    protected $customer;
    protected $maid;

    protected function setUp(): void
    {
        parent::setUp();

        // Create fresh data for each test using factories
        $this->customer = \App\Models\CRM::factory()->create();
        $this->maid = \App\Models\Employee::factory()->create();
    }

    /** @test */
    public function it_validates_required_fields_on_store()
    {
        $response = $this->postJson('/api/am-monthly-contracts', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['start_date', 'customer_id', 'maid_id', 'installment']);
    }

    /** @test */
    public function it_fails_validation_if_customer_or_maid_does_not_exist()
    {
        $payload = [
            'start_date' => '2026-03-01',
            'customer_id' => 999999, // Non-existent
            'maid_id' => 999999, // Non-existent
            'installment' => [['date' => '2026-03-01', 'amount' => 500]]
        ];

        $response = $this->postJson('/api/am-monthly-contracts', $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['customer_id', 'maid_id']);
    }

    /** @test */
    public function it_fails_validation_if_dates_are_invalid()
    {
        $payload = [
            'start_date' => 'not-a-date',
            'ended_date' => 'not-a-date',
            'customer_id' => $this->customer->id,
            'maid_id' => $this->maid->id,
            'installment' => [['date' => 'not-a-date', 'amount' => 500]]
        ];

        $response = $this->postJson('/api/am-monthly-contracts', $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['start_date', 'ended_date', 'installment.0.date']);
    }

    /** @test */
    public function it_fails_validation_if_installment_amount_is_missing_or_invalid()
    {
        $payload = [
            'start_date' => '2026-03-01',
            'customer_id' => $this->customer->id,
            'maid_id' => $this->maid->id,
            'installment' => [
                ['date' => '2026-03-01', 'amount' => -100], // Negative amount
                ['date' => '2026-03-01', 'amount' => 'abc'] // Non-numeric
            ]
        ];

        $response = $this->postJson('/api/am-monthly-contracts', $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['installment.0.amount', 'installment.1.amount']);
    }

    /** @test */
    public function it_validates_installment_structure()
    {
        $payload = [
            'start_date' => '2026-03-01',
            'customer_id' => $this->customer->id,
            'maid_id' => $this->maid->id,
            'installment' => [
                ['note' => 'Missing date and amount'] // Invalid Item
            ]
        ];

        $response = $this->postJson('/api/am-monthly-contracts', $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['installment.0.date', 'installment.0.amount']);
    }

    /** @test */
    public function it_can_create_a_monthly_contract()
    {
        $payload = [
            'start_date' => '2026-03-01',
            'ended_date' => '2027-03-01',
            'customer_id' => $this->customer->id,
            'maid_id' => $this->maid->id,
            'installment' => [
                [
                    'date' => '2026-03-01',
                    'amount' => 1000,
                    'note' => 'First Installment'
                ],
                [
                    'date' => '2026-04-01',
                    'amount' => 1000,
                    'note' => 'Second Installment'
                ]
            ]
        ];

        $response = $this->postJson('/api/am-monthly-contracts', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('data.date', '2026-03-01');

        $this->assertDatabaseHas('am_primary_contracts', [
            'crm_id' => $this->customer->id,
            'date' => '2026-03-01'
        ]);
        
        // Use ID from response to verify relations
        $contractId = $response->json('data.id');
        
        $this->assertDatabaseHas('am_contract_movments', [
            'am_contract_id' => $contractId,
            'employee_id' => $this->maid->id
        ]);

        // Check Installments count (should be 2)
        // Note: standard assertDatabaseCount might count ALL, so better strict check logic
        // But let's check basic existence
        $this->assertDatabaseHas('am_installments', [
            'amount' => 1000,
            'note' => 'First Installment'
        ]);
    }

    /** @test */
    public function it_can_update_a_monthly_contract()
    {
        // 1. Create first
        $contract = AmPrimaryContract::create([
             'date' => '2026-01-01',
             'crm_id' => $this->customer->id,
             'status' => 1,
             'type' => 2
        ]);
        
        $payload = [
            'start_date' => '2026-02-01', // Changed date
            'ended_date' => '2027-02-01',
            'customer_id' => $this->customer->id,
            'maid_id' => $this->maid->id,
            'installment' => [
                ['date' => '2026-02-01', 'amount' => 1500, 'note' => 'Updated Amount']
            ]
        ];

        $response = $this->putJson("/api/am-monthly-contracts/{$contract->id}", $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('am_primary_contracts', [
            'id' => $contract->id,
            'date' => '2026-02-01'
        ]);
        
        // Verify installment related to new update
        $this->assertDatabaseHas('am_installments', [
            'amount' => 1500,
            'note' => 'Updated Amount'
        ]);
    }

    /** @test */
    public function it_can_delete_a_contract()
    {
        $contract = AmPrimaryContract::create([
             'date' => '2026-01-01',
             'crm_id' => $this->customer->id,
             'status' => 1,
             'type' => 2
        ]);

        $response = $this->deleteJson("/api/am-monthly-contracts/{$contract->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('am_primary_contracts', [
            'id' => $contract->id
        ]);
    }
}
