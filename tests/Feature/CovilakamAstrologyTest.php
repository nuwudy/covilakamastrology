<?php

namespace Tests\Feature;

use App\Models\Consultation;
use App\Models\MediaItem;
use App\Models\Post;
use App\Models\User;
use App\Services\VedicDobCalculator;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CovilakamAstrologyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_homepage_loads_successfully_with_all_branding_and_sections(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        // Strict branding checks
        $response->assertSee('DR. E. K. Raja Varma');
        $response->assertSee('(Vidya Vachaspathi in Vedic Astrology)');
        $response->assertSee('COVILAKAM', false);
        $response->assertSee('Explore. Discover. Transform.');

        // Contacts & Payments
        $response->assertSee('7907052160');
        $response->assertSee('094473 27450');
        $response->assertSee('varmaji@covilakamastrology.com');
        $response->assertSee('ekrvarma@gmail.com');
        $response->assertSee('www.covilakamastrology.com');

        // Credentials
        $response->assertSee('Gold Medalist');
        $response->assertSee('Ph.D.');
        $response->assertSee('11009');
        $response->assertSee('2022');

        // Core Services
        $response->assertSee('Accurate Predictions');
        $response->assertSee('Jathakam Reports');
        $response->assertSee('Marriage Match Reports');
        $response->assertSee('Gem Prediction Reports');
        $response->assertSee('Muhoorthams');

        // Video Ordering Verification: Video 1 and Video 2
        $response->assertSee('ഓൺലൈൻ അസ്ട്രോളജി');
        $response->assertSee('ഇവ ചെയ്തില്ലെങ്കിൽ സ്ത്രീകൾക്ക് ദോഷം ആണോ ?');

        // First Seeded Blog Post
        $response->assertSee('ജ്യോതിഷവും ജീവിതസരണിയും');

        // Footer Admin Login Link for authorized personnel
        $response->assertSee('Admin Login');
    }

    public function test_vedic_dob_calculator_service(): void
    {
        $calculator = new VedicDobCalculator();
        $result = $calculator->calculate('1990-09-28', 'Rajesh', 'Accurate Predictions');

        $this->assertEquals(1, $result['mulank']); // 28 -> 2+8=10 -> 1
        $this->assertEquals(2, $result['bhagyank']); // 28-09-1990 -> 2+8+0+9+1+9+9+0 = 38 -> 11 -> 2
        $this->assertStringContainsString('Surya', $result['ruling_planet']['en']);
        $this->assertStringContainsString('സൂര്യൻ', $result['ruling_planet']['ml']);
        $this->assertStringContainsString('Kanni', $result['solar_sign']['name_ml']);
        $this->assertStringContainsString('Ruby', $result['gemstone_en']);
        $this->assertStringContainsString('917907052160', $result['whatsapp_url']);
        $this->assertNotEmpty($result['career_prediction']);
        $this->assertNotEmpty($result['relationship_prediction']);
        $this->assertNotEmpty($result['health_prediction']);
        $this->assertNotEmpty($result['mantra_sanskrit']);
    }

    public function test_calculate_dob_endpoint(): void
    {
        // 1. Phone is required: missing phone should fail validation
        $failResponse = $this->postJson('/calculate-dob', [
            'name' => 'Suresh Kumar',
            'birth_date' => '1985-05-15',
        ]);
        $failResponse->assertStatus(422);
        $failResponse->assertJsonValidationErrors(['phone']);

        // 2. Successful calculation with mandatory phone & selected language
        $response = $this->postJson('/calculate-dob', [
            'name' => 'Suresh Kumar',
            'birth_date' => '1985-05-15',
            'phone' => '+91 94473 11111',
            'language' => 'ml',
            'service_requested' => 'Jathakam Reports',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonStructure([
            'data' => [
                'mulank',
                'bhagyank',
                'ruling_planet',
                'destiny_planet',
                'solar_sign',
                'gemstone_en',
                'whatsapp_url',
                'report_url',
                'career_prediction',
                'relationship_prediction',
            ]
        ]);

        $this->assertDatabaseHas('consultations', [
            'name' => 'Suresh Kumar',
            'phone' => '+91 94473 11111',
            'status' => 'pending',
            'service_requested' => 'Jathakam Reports',
        ]);

        // 3. Test updating requested service from the results WhatsApp funnel
        $consultationId = $response->json('data.consultation_id');
        $patchResponse = $this->patchJson("/consultations/{$consultationId}/service", [
            'service_requested' => 'Marriage Match Reports',
        ]);
        $patchResponse->assertStatus(200);
        $this->assertDatabaseHas('consultations', [
            'id' => $consultationId,
            'service_requested' => 'Marriage Match Reports',
        ]);
    }

    public function test_client_reads_prediction_report_on_site(): void
    {
        $consultation = Consultation::first();
        $this->assertNotNull($consultation);

        $response = $this->get('/prediction/' . $consultation->id);
        $response->assertStatus(200);
        $response->assertSee($consultation->name);
        $response->assertSee('COVILAKAM ASTROLOGY');
        $response->assertSee('DR. E. K. Raja Varma');
        $response->assertSee('(Vidya Vachaspathi in Vedic Astrology)');
        $response->assertSee('Life Path & Soul Nature', false);
        $response->assertSee('Career & Wealth', false);
        $response->assertSee('Love & Family', false);
    }

    public function test_book_consultation_endpoint(): void
    {
        $response = $this->post('/book-consultation', [
            'name' => 'Deepa Nair',
            'phone' => '+91 98470 22222',
            'service_requested' => 'Marriage Match Reports',
            'birth_date' => '1995-11-20',
            'message' => 'Looking for marriage horoscope matching.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('consultations', [
            'name' => 'Deepa Nair',
            'phone' => '+91 98470 22222',
            'service_requested' => 'Marriage Match Reports',
        ]);
    }

    public function test_blog_index_and_show(): void
    {
        $response = $this->get('/blog');
        $response->assertStatus(200);
        $response->assertSee('ജ്യോതിഷവും ജീവിതസരണിയും');

        $post = Post::where('slug', 'jyothishavum-jeevithasaranium')->first();
        $this->assertNotNull($post);

        $showResponse = $this->get('/blog/' . $post->slug);
        $showResponse->assertStatus(200);
        $showResponse->assertSee($post->title);
        $showResponse->assertSee('DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)');
        $showResponse->assertSee('7907052160');
    }

    public function test_visiting_card_pages(): void
    {
        $response1 = $this->get('/visiting-card');
        $response1->assertStatus(200);
        $response1->assertSee('DR. E. K. Raja Varma');
        $response1->assertSee('(Vidya Vachaspathi in Vedic Astrology)');

        $response2 = $this->get('/visiting-card/print');
        $response2->assertStatus(200);
        $response2->assertSee('DR. E. K. Raja Varma');
    }

    public function test_admin_media_library_index(): void
    {
        $user = User::first();
        $response = $this->actingAs($user)->get('/admin/media');
        $response->assertStatus(200);
        $response->assertSee('Covilakam Media Library');
        $response->assertSee('Upload New Media');
        $response->assertSee('WebP');
    }

    public function test_admin_media_library_upload_and_webp_conversion(): void
    {
        Storage::fake('public');
        $user = User::first();

        // Create a test image
        $image = UploadedFile::fake()->image('sacred-yantra.jpg', 600, 600);

        $response = $this->actingAs($user)->post('/admin/media', [
            'file' => $image,
            'title' => 'Sacred Yantra Test',
            'alt_text' => 'Yantra Description',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('media_items', [
            'title' => 'Sacred Yantra Test',
            'file_type' => 'image',
            'is_webp' => true,
        ]);
    }

    public function test_admin_can_login_with_custom_credentials(): void
    {
        $loginResponse = $this->get('/admin/login');
        $loginResponse->assertStatus(200);
        $loginResponse->assertSee('Administrator Login');

        $response = $this->post('/admin/login', [
            'email' => 'admin@covilakamastrology@gmail.com',
            'password' => 'Varmaji2160#',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_admin_logout(): void
    {
        $this->post('/admin/login', [
            'email' => 'admin@covilakamastrology@gmail.com',
            'password' => 'Varmaji2160#',
        ]);

        $response = $this->post('/admin/logout');
        $response->assertRedirect(route('home'));
        $this->assertGuest();
    }
}
