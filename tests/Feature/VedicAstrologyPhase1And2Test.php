<?php

namespace Tests\Feature;

use App\Models\AstrologyReading;
use App\Models\Consultation;
use App\Services\Astrology\AstrologyEngineService;
use App\Services\Astrology\ChitrapakshaEphemerisService;
use App\Services\Astrology\PanchangaService;
use App\Services\Astrology\VargaAndBhavaService;
use App\Services\Astrology\DashaService;
use App\Services\Astrology\AshtakavargaAndDignityService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VedicAstrologyPhase1And2Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_astrology_engine_calculates_deterministic_sidereal_chart(): void
    {
        $engine = new AstrologyEngineService();

        $result = $engine->calculate([
            'name' => 'Adithya Varma',
            'gender' => 'male',
            'birth_date' => '1992-05-18',
            'birth_time' => '10:45:00',
            'is_approximate_time' => false,
            'birth_place' => 'Ernakulam / Kochi, Kerala',
            'latitude' => 9.9312,
            'longitude' => 76.2673,
            'timezone' => 'Asia/Kolkata',
            'language' => 'en',
        ]);

        $this->assertEquals('success', $result['status']);
        $this->assertEquals('Adithya Varma', $result['full_name']);
        $this->assertEquals('male', $result['gender']);

        // Chitrapaksha Ayanamsa should be around 23.75° for 1992
        $this->assertGreaterThan(23.0, $result['ayanamsa_deg']);
        $this->assertLessThan(24.5, $result['ayanamsa_deg']);

        // Check 9 planets + Lagna + Gulika
        $this->assertArrayHasKey('Su', $result['planets']);
        $this->assertArrayHasKey('Mo', $result['planets']);
        $this->assertArrayHasKey('Ma', $result['planets']);
        $this->assertArrayHasKey('Me', $result['planets']);
        $this->assertArrayHasKey('Ju', $result['planets']);
        $this->assertArrayHasKey('Ve', $result['planets']);
        $this->assertArrayHasKey('Sa', $result['planets']);
        $this->assertArrayHasKey('Ra', $result['planets']);
        $this->assertArrayHasKey('Ke', $result['planets']);
        $this->assertNotEmpty($result['lagna']);
        $this->assertNotEmpty($result['gulika']);

        // Shadvargas
        $this->assertNotEmpty($result['shadvarga']);
        $this->assertArrayHasKey('d1_rasi', $result['shadvarga']['Su']);
        $this->assertArrayHasKey('d9_navamsha', $result['shadvarga']['Mo']);
        $this->assertArrayHasKey('is_vargottama', $result['shadvarga']['Ju']);

        // South Indian Chart Grids
        $this->assertCount(12, $result['chart_grid_d1']);
        $this->assertCount(12, $result['chart_grid_d9']);

        // Ashtakavarga SAV total must equal exactly 337 points (Vedanga Jyothisham Page 67)
        $this->assertEquals(337, $result['ashtakavarga']['sav_total']);

        // Vimshottari Dasha
        $this->assertNotEmpty($result['garbhashishta']);
        $this->assertNotEmpty($result['active_dasha']['mahadasha']);
        $this->assertNotEmpty($result['active_dasha']['apahara']);

        // Gemstone Wearing Rule for Male (Right Hand)
        $this->assertEquals('Right Hand', $result['gemstone']['hand_en']);
        $this->assertStringContainsString('Right Hand', $result['wearing_rule']['en']);
        $this->assertStringContainsString('വലതുകൈ', $result['wearing_rule']['ml']);
    }

    public function test_gemstone_engine_gender_rule_for_female(): void
    {
        $engine = new AstrologyEngineService();

        $result = $engine->calculate([
            'name' => 'Devika Pillai',
            'gender' => 'female',
            'birth_date' => '1995-11-20',
            'birth_time' => '07:15:00',
            'language' => 'ml',
        ]);

        $this->assertEquals('female', $result['gender']);
        $this->assertEquals('Left Hand', $result['gemstone']['hand_en']);
        $this->assertStringContainsString('Left Hand', $result['wearing_rule']['en']);
        $this->assertStringContainsString('ഇടതുകൈ', $result['wearing_rule']['ml']);
    }

    public function test_api_astrology_calculate_endpoint(): void
    {
        $response = $this->postJson('/api/astrology/calculate', [
            'name' => 'K. R. Menon',
            'gender' => 'male',
            'birth_date' => '1988-08-15',
            'birth_time' => '06:30:00',
            'birth_place' => 'Thrissur, Kerala',
            'phone' => '+91 98470 12345',
            'language' => 'en',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonStructure([
            'success',
            'uuid',
            'data' => [
                'full_name',
                'solar_sign',
                'moon_sign',
                'lagna',
                'gulika',
                'nakshatra',
                'chart_grid_d1',
                'chart_grid_d9',
                'ashtakavarga' => ['sav_total'],
                'dasha' => ['active_dasha'],
                'gemstone',
            ],
        ]);

        $uuid = $response->json('uuid');
        $this->assertDatabaseHas('astrology_readings', [
            'uuid' => $uuid,
            'full_name' => 'K. R. Menon',
            'whatsapp_number' => '+91 98470 12345',
        ]);

        $this->assertDatabaseHas('consultations', [
            'name' => 'K. R. Menon',
            'whatsapp_number' => '+91 98470 12345',
        ]);
    }

    public function test_homepage_contains_phase_1_upgrades_and_no_undefined_bugs(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        // Form fields
        $response->assertSee('Gender *');
        $response->assertSee('Male (പുരുഷൻ / Right Hand)');
        $response->assertSee('Female (സ്ത്രീ / Left Hand)');
        $response->assertSee('Birth Time');
        $response->assertSee("I don't know my exact birth time", false);
        $response->assertSee('Birth Place (City / Town) *');
        $response->assertSee('WhatsApp Number');

        // Read-only print protection & Kundali chart markup
        $response->assertSee('free-reading-protected');
        $response->assertSee('@media print');
        $response->assertSee('South Indian Kundali');
        $response->assertSee('രാശി ചക്രം (D1)');
        $response->assertSee('നവാംശ ചക്രം (D9)');

        // Undefined text assertions
        $response->assertDontSee('(undefined)');
        $response->assertDontSee('Wearing Rule: undefined');
    }
}
