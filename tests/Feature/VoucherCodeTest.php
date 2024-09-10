<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\VoucherCode;
use Laravel\Sanctum\Sanctum;

class VoucherCodeTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function authenticated_user_can_generate_a_voucher_code()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/voucher/generate');

        $response->assertStatus(201)
                 ->assertJsonStructure(['code']);

        $this->assertDatabaseCount('voucher_codes', 1);
    }

    #[Test]
    public function user_can_view_own_voucher_codes()
    {
        $user = User::factory()->create();
        VoucherCode::factory()->count(2)->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/vouchers');

        $response->assertStatus(200)
                 ->assertJsonCount(2);
    }

    #[Test]
    public function user_cannot_generate_more_than_10_voucher_codes()
    {
        $user = User::factory()->create();
        VoucherCode::factory()->count(10)->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/voucher/generate');

        $response->assertStatus(400)
                 ->assertJson(['error' => 'Maximum voucher codes limit reached']);
    }

    #[Test]
    public function user_can_delete_own_voucher_code()
    {
        $user = User::factory()->create();
        $voucherCode = VoucherCode::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $response = $this->deleteJson("/api/voucher/{$voucherCode->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('voucher_codes', ['id' => $voucherCode->id]);
    }
}