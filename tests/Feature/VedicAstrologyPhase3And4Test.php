<?php

namespace Tests\Feature;

use App\Models\AstrologyReading;
use App\Services\Astrology\AstrologyEngineService;
use App\Services\Astrology\AstrologyPdfService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VedicAstrologyPhase3And4Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\VedangaJyothishamRulesSeeder::class);
    }

    /**
     * Benchmark Test: May 01, 2003, 08:00 AM, Ernakulam.
     */
    public function test_benchmark_birth_chart_calculation(): void
    {
        $engine = app(AstrologyEngineService::class);

        $input = [
            'name' => 'Adithya Varma',
            'gender' => 'male',
            'birth_date' => '2003-05-01',
            'birth_time' => '08:00:00',
            'is_approximate_time' => false,
            'birth_place' => 'Ernakulam / Kochi, Kerala, India',
            'latitude' => 9.9312,
            'longitude' => 76.2673,
            'timezone' => 'Asia/Kolkata',
            'phone' => '+919447327450',
            'language' => 'en',
        ];

        $chart = $engine->calculate($input);

        $this->assertEquals('success', $chart['status']);
        $this->assertNotNull($chart['lagna']);
        $this->assertNotNull($chart['moon_sign']);
        $this->assertNotNull($chart['solar_sign']);
        $this->assertNotNull($chart['nakshatra']);

        // Check Ayanamsa is approximately 23.85° (Lahiri Chitrapaksha for 2003)
        $this->assertGreaterThan(23.5, $chart['ayanamsa_deg']);
        $this->assertLessThan(24.5, $chart['ayanamsa_deg']);

        // Sun in Aries (Exalted in Sidereal Nirayana Aries for May 1)
        $this->assertEquals(1, $chart['solar_sign']['index']);

        // Lagna in Taurus (approx 08:00 AM in May in Kerala)
        $this->assertEquals(2, $chart['lagna']['rasi_index']);

        // Moon in Aries (Bharani Nakshatra)
        $this->assertEquals(1, $chart['moon_sign']['index']);

        // Total SAV points must equal 337
        $this->assertEquals(337, array_sum($chart['ashtakavarga']['sav']));

        // Check Vedanga Predictions presence
        $this->assertArrayHasKey('vedanga_predictions', $chart);
        $this->assertNotEmpty($chart['vedanga_predictions']['gulika']);
        $this->assertNotEmpty($chart['vedanga_predictions']['yogas']);
        $this->assertNotEmpty($chart['vedanga_predictions']['gocharaphala']);
        $this->assertNotEmpty($chart['vedanga_predictions']['bhavas']);
    }

    /**
     * Test API Calculation and AstrologyReading Persistence.
     */
    public function test_api_astrology_calculate_persists_reading(): void
    {
        $payload = [
            'name' => 'Dr. Raja Varma Seeker',
            'gender' => 'female',
            'birth_date' => '1995-10-15',
            'birth_time' => '10:30:00',
            'is_approximate_time' => false,
            'birth_place' => 'Thiruvananthapuram, Kerala',
            'latitude' => 8.5241,
            'longitude' => 76.9366,
            'timezone' => 'Asia/Kolkata',
            'phone' => '+917907052160',
            'language' => 'ml',
        ];

        $response = $this->postJson(route('astrology.calculate'), $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $uuid = $response->json('uuid');
        $this->assertNotEmpty($uuid);

        $this->assertDatabaseHas('astrology_readings', [
            'uuid' => $uuid,
            'full_name' => 'Dr. Raja Varma Seeker',
            'gender' => 'female',
            'paid_tier' => 'free',
        ]);
    }

    /**
     * Test Razorpay Order Creation Endpoint.
     */
    public function test_astrology_create_order_for_tier_100_and_500(): void
    {
        $engine = app(AstrologyEngineService::class);
        $calc = $engine->calculate([
            'dob' => '1998-08-20',
            'birth_time' => '14:15:00',
        ]);

        $reading = AstrologyReading::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'full_name' => 'Devotee Ananya',
            'gender' => 'female',
            'whatsapp_number' => '+919876543210',
            'language' => 'en',
            'dob' => '1998-08-20',
            'birth_time' => '14:15:00',
            'is_approximate_time' => false,
            'birth_place' => 'Ernakulam',
            'latitude' => 9.9312,
            'longitude' => 76.2673,
            'timezone' => 'Asia/Kolkata',
            'chart_data' => $calc,
            'paid_tier' => 'free',
        ]);

        // Tier 100
        $res100 = $this->postJson(route('astrology.reading.create-order', ['uuid' => $reading->uuid]), [
            'tier' => 'tier_100',
        ]);
        $res100->assertStatus(200);
        $res100->assertJson([
            'success' => true,
            'tier' => 'tier_100',
            'amount' => 10000,
            'amount_inr' => 100,
        ]);

        // Tier 500
        $res500 = $this->postJson(route('astrology.reading.create-order', ['uuid' => $reading->uuid]), [
            'tier' => 'tier_500',
        ]);
        $res500->assertStatus(200);
        $res500->assertJson([
            'success' => true,
            'tier' => 'tier_500',
            'amount' => 50000,
            'amount_inr' => 500,
        ]);
    }

    /**
     * Test Payment Verification and Tier Unlocking.
     */
    public function test_astrology_verify_payment_and_unlocks_tier(): void
    {
        $engine = app(AstrologyEngineService::class);
        $calc = $engine->calculate([
            'dob' => '1990-01-01',
            'birth_time' => '06:00:00',
        ]);

        $reading = AstrologyReading::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'full_name' => 'Krishnan Namboothiri',
            'gender' => 'male',
            'whatsapp_number' => '+919447327450',
            'language' => 'ml',
            'dob' => '1990-01-01',
            'birth_time' => '06:00:00',
            'is_approximate_time' => false,
            'birth_place' => 'Thrissur',
            'latitude' => 10.5276,
            'longitude' => 76.2144,
            'timezone' => 'Asia/Kolkata',
            'chart_data' => $calc,
            'paid_tier' => 'free',
        ]);

        $verifyRes = $this->postJson(route('astrology.reading.verify-payment', ['uuid' => $reading->uuid]), [
            'tier' => 'tier_500',
            'razorpay_payment_id' => 'pay_test_123456',
            'razorpay_order_id' => 'order_test_123456',
        ]);

        $verifyRes->assertStatus(200);
        $verifyRes->assertJson([
            'success' => true,
            'tier' => 'tier_500',
        ]);

        $reading->refresh();
        $this->assertEquals('tier_500', $reading->paid_tier);
        $this->assertEquals('pay_test_123456', $reading->razorpay_payment_id);
    }

    /**
     * Test PDF Download Access Control and Content Type.
     */
    public function test_pdf_download_access_control_and_generation(): void
    {
        $engine = app(AstrologyEngineService::class);
        $calc = $engine->calculate([
            'dob' => '2000-03-25',
            'birth_time' => '11:00:00',
        ]);

        $reading = AstrologyReading::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'full_name' => 'Sreejith Varma',
            'gender' => 'male',
            'whatsapp_number' => '+919447327450',
            'language' => 'en',
            'dob' => '2000-03-25',
            'birth_time' => '11:00:00',
            'is_approximate_time' => false,
            'birth_place' => 'Ernakulam',
            'latitude' => 9.9312,
            'longitude' => 76.2673,
            'timezone' => 'Asia/Kolkata',
            'chart_data' => $calc,
            'paid_tier' => 'free',
        ]);

        // 1. Free reading cannot download certified PDF
        $freeRes = $this->get(route('astrology.reading.download-pdf', ['uuid' => $reading->uuid]));
        $freeRes->assertStatus(403);

        // 2. Unlock Tier 100 and download
        $reading->update(['paid_tier' => 'tier_100']);
        $tier100Res = $this->get(route('astrology.reading.download-pdf', ['uuid' => $reading->uuid]));
        $tier100Res->assertStatus(200);
        $this->assertEquals('application/pdf', $tier100Res->headers->get('Content-Type'));
        $this->assertStringStartsWith('%PDF-', $tier100Res->getContent());

        // 3. Unlock Tier 500 and download
        $reading->update(['paid_tier' => 'tier_500']);
        $tier500Res = $this->get(route('astrology.reading.download-pdf', ['uuid' => $reading->uuid]));
        $tier500Res->assertStatus(200);
        $this->assertEquals('application/pdf', $tier500Res->headers->get('Content-Type'));
        $this->assertStringStartsWith('%PDF-', $tier500Res->getContent());
    }
}
