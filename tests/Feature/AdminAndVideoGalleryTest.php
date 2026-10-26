<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use App\Models\Video;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\VideoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAndVideoGalleryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_six_real_youtube_videos_are_seeded_in_exact_order(): void
    {
        $videos = Video::orderBy('sort_order', 'asc')->get();

        $this->assertCount(6, $videos);

        // Video 1
        $this->assertEquals(1, $videos[0]->sort_order);
        $this->assertEquals('5LGNeJ2OJdc', $videos[0]->youtube_id);
        $this->assertStringContainsString('കണ്ടവരുണ്ടോ', $videos[0]->title);

        // Video 2
        $this->assertEquals(2, $videos[1]->sort_order);
        $this->assertEquals('ZFzqmHgEDKQ', $videos[1]->youtube_id);
        $this->assertStringContainsString('ഓൺലൈൻ ജ്യോതിഷം', $videos[1]->title);

        // Video 3
        $this->assertEquals(3, $videos[2]->sort_order);
        $this->assertEquals('bV6yfbEqGLw', $videos[2]->youtube_id);
        $this->assertStringContainsString('കല്യാണത്തിന് പൊരുത്തം', $videos[3 - 1]->title);

        // Video 4
        $this->assertEquals(4, $videos[3]->sort_order);
        $this->assertEquals('R5D1mF3Jf64', $videos[3]->youtube_id);
        $this->assertStringContainsString('മെസ്സേജിലൂടെ പ്രണയം', $videos[3]->title);

        // Video 5
        $this->assertEquals(5, $videos[4]->sort_order);
        $this->assertEquals('PurQ3FTbsuU', $videos[4]->youtube_id);
        $this->assertStringContainsString('അവർക്കു പഠിക്കാൻ പറ്റാത്തതിന്', $videos[4]->title);

        // Video 6
        $this->assertEquals(6, $videos[5]->sort_order);
        $this->assertEquals('cLnlMm6qP74', $videos[5]->youtube_id);
        $this->assertStringContainsString('ചൊവ്വാദോഷമാണ്', $videos[5]->title);
    }

    public function test_smart_youtube_id_parser_handles_various_formats(): void
    {
        $this->assertEquals('5LGNeJ2OJdc', Video::parseYoutubeId('https://youtu.be/5LGNeJ2OJdc?si=mO3USNoPfDtO4MXR'));
        $this->assertEquals('ZFzqmHgEDKQ', Video::parseYoutubeId('https://youtu.be/ZFzqmHgEDKQ?si=NxacyL_HjoelrMl0'));
        $this->assertEquals('bV6yfbEqGLw', Video::parseYoutubeId('bV6yfbEqGLw'));
        $this->assertEquals('R5D1mF3Jf64', Video::parseYoutubeId('https://youtu.be/R5D1mF3Jf64?si=07K6H8hahXpz3dA9'));
        $this->assertEquals('PurQ3FTbsuU', Video::parseYoutubeId('https://youtu.be/PurQ3FTbsuU?si=W-DOQF6g6mA_rqQx'));
        $this->assertEquals('cLnlMm6qP74', Video::parseYoutubeId('https://youtu.be/cLnlMm6qP74?si=yf5IkZS6dngHlOF1'));
    }

    public function test_homepage_renders_videos_and_watch_all_button(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Video Gallery elements on homepage
        $response->assertSee('Vedic Astrology', false);
        $response->assertSee('Video Gallery', false);
        $response->assertSee('5LGNeJ2OJdc', false);
        $response->assertSee('activeVideoModal', false); // Lightbox modal

        // Watch All Video buttons leading to dedicated video gallery page
        $response->assertSee(route('videos.index'), false);
        $response->assertSee('Watch All Vedic Astrology Videos', false);

        // Header navigation connects to videos page
        $response->assertSee(route('videos.index'), false);

        // Footer guest link
        $response->assertSee('Admin Login', false);
    }

    public function test_exclusive_video_gallery_page_renders_with_prominent_hero_and_two_column_mobile_grid(): void
    {
        $response = $this->get('/videos');
        $response->assertStatus(200);

        // Video branding with CINEMA removed from title
        $response->assertSee('VEDIC ASTROLOGY', false);
        $response->assertSee('VIDEO GALLERY', false);
        $response->assertDontSee('CINEMA GALLERY', false);
        $response->assertSee('Featured Discourse', false);
        $response->assertSee('Watch Premiere Now', false);

        // Strict 2-column mobile grid check
        $response->assertSee('grid-cols-2', false);
        $response->assertSee('md:grid-cols-3', false);
        $response->assertSee('lg:grid-cols-4', false);

        // The 6 seeded YouTube video IDs are present
        $response->assertSee('5LGNeJ2OJdc', false);
        $response->assertSee('ZFzqmHgEDKQ', false);
        $response->assertSee('bV6yfbEqGLw', false);
        $response->assertSee('R5D1mF3Jf64', false);
        $response->assertSee('PurQ3FTbsuU', false);
        $response->assertSee('cLnlMm6qP74', false);

        // Interactive controls: category filters, search & theater modal
        $response->assertSee('activeCategory', false);
        $response->assertSee('searchQuery', false);
        $response->assertSee('activeVideoModal', false);
        $response->assertSee('Vedic Video Player', false);

        // VIP Consultation ticket box
        $response->assertSee('Direct Personal Astrology Consultation', false);
        $response->assertSee('Book Consultation Online', false);
    }

    public function test_individual_video_show_page_loads_with_player(): void
    {
        $response = $this->get('/videos/5LGNeJ2OJdc');
        $response->assertStatus(200);

        $response->assertSee('Now Playing Discourse', false);
        $response->assertSee('Back to Video Gallery', false);
        $response->assertSee('5LGNeJ2OJdc', false);
        $response->assertSee('More Vedic Astrology', false);
    }

    public function test_admin_can_login_with_provided_credentials(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'varmaji@covilakamastrology.com',
            'password' => 'Covilakam@2026',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();
    }

    public function test_admin_dashboard_loads_for_authenticated_user(): void
    {
        $admin = User::where('email', 'varmaji@covilakamastrology.com')->first();

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Overview');
        $response->assertSee('DR. E. K. Raja Varma');
        $response->assertSee('Video Gallery');
        $response->assertSee('Articles & Wisdom', false);
    }

    public function test_admin_can_crud_videos(): void
    {
        $admin = User::where('email', 'varmaji@covilakamastrology.com')->first();

        // 1. Index
        $response = $this->actingAs($admin)->get('/admin/videos');
        $response->assertStatus(200);
        $response->assertSee('ZFzqmHgEDKQ');

        // 2. Create Video
        $postResponse = $this->actingAs($admin)->post('/admin/videos', [
            'title' => 'നവഗ്രഹ ശാന്തി പൂജകൾ',
            'youtube_url' => 'https://youtu.be/dQw4w9WgXcQ',
            'description' => 'നവഗ്രഹ ദോഷ പരിഹാരങ്ങൾ',
            'duration' => '10:00',
            'sort_order' => 9,
            'is_active' => '1',
        ]);
        $postResponse->assertRedirect('/admin/videos');

        $newVideo = Video::where('youtube_id', 'dQw4w9WgXcQ')->first();
        $this->assertNotNull($newVideo);
        $this->assertEquals(9, $newVideo->sort_order);

        // 3. Edit Video
        $editResponse = $this->actingAs($admin)->get("/admin/videos/{$newVideo->id}/edit");
        $editResponse->assertStatus(200);

        // 4. Update Video
        $updateResponse = $this->actingAs($admin)->put("/admin/videos/{$newVideo->id}", [
            'title' => 'നവഗ്രഹ ശാന്തി പൂജകൾ (Updated)',
            'youtube_url' => 'https://youtu.be/dQw4w9WgXcQ',
            'description' => 'Updated Description',
            'duration' => '11:00',
            'sort_order' => 10,
            'is_active' => '1',
        ]);
        $updateResponse->assertRedirect('/admin/videos');
        $this->assertEquals('നവഗ്രഹ ശാന്തി പൂജകൾ (Updated)', $newVideo->fresh()->title);

        // 5. Toggle Status
        $toggleResponse = $this->actingAs($admin)->post("/admin/videos/{$newVideo->id}/toggle");
        $toggleResponse->assertRedirect();
        $this->assertFalse($newVideo->fresh()->is_active);

        // 6. Delete Video
        $deleteResponse = $this->actingAs($admin)->delete("/admin/videos/{$newVideo->id}");
        $deleteResponse->assertRedirect('/admin/videos');
        $this->assertNull(Video::find($newVideo->id));
    }

    public function test_admin_can_crud_posts(): void
    {
        $admin = User::where('email', 'varmaji@covilakamastrology.com')->first();

        // 1. Index
        $response = $this->actingAs($admin)->get('/admin/posts');
        $response->assertStatus(200);

        // 2. Create Post
        $createResponse = $this->actingAs($admin)->post('/admin/posts', [
            'title' => 'Test Astrological Article',
            'slug' => 'test-astrological-article',
            'category' => 'Vedic Philosophy',
            'reading_time' => '4 min read',
            'excerpt' => 'Short test excerpt',
            'body' => '<p>Test body content for astrology insight.</p>',
            'author_name' => 'DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)',
            'is_published' => '1',
        ]);
        $createResponse->assertRedirect('/admin/posts');

        $post = Post::where('slug', 'test-astrological-article')->first();
        $this->assertNotNull($post);
        $this->assertNotNull($post->published_at);

        // 3. Edit & Update Post
        $updateResponse = $this->actingAs($admin)->put("/admin/posts/{$post->id}", [
            'title' => 'Updated Astrological Article',
            'slug' => 'test-astrological-article',
            'category' => 'Gemology',
            'reading_time' => '5 min read',
            'excerpt' => 'Updated excerpt',
            'body' => '<p>Updated body.</p>',
            'author_name' => 'DR. E. K. Raja Varma (Vidya Vachaspathi in Vedic Astrology)',
            'is_published' => '1',
        ]);
        $updateResponse->assertRedirect('/admin/posts');
        $this->assertEquals('Updated Astrological Article', $post->fresh()->title);

        // 4. Delete Post
        $deleteResponse = $this->actingAs($admin)->delete("/admin/posts/{$post->id}");
        $deleteResponse->assertRedirect('/admin/posts');
        $this->assertNull(Post::find($post->id));
    }
}
