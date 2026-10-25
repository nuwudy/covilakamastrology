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

    public function test_eight_real_youtube_videos_are_seeded_in_exact_order(): void
    {
        $videos = Video::orderBy('sort_order', 'asc')->get();

        $this->assertCount(8, $videos);

        // Video 1
        $this->assertEquals(1, $videos[0]->sort_order);
        $this->assertEquals('ZFzqmHgEDKQ', $videos[0]->youtube_id);
        $this->assertStringContainsString('ഓൺലൈൻ അസ്ട്രോളജി', $videos[0]->title);

        // Video 2
        $this->assertEquals(2, $videos[1]->sort_order);
        $this->assertEquals('xAo9vh-tMpw', $videos[1]->youtube_id);
        $this->assertStringContainsString('ഇവ ചെയ്തില്ലെങ്കിൽ സ്ത്രീകൾക്ക് ദോഷം ആണോ ?', $videos[1]->title);

        // Video 3
        $this->assertEquals(3, $videos[2]->sort_order);
        $this->assertEquals('ugqn3yZzljU', $videos[2]->youtube_id);

        // Video 4
        $this->assertEquals(4, $videos[3]->sort_order);
        $this->assertEquals('x6X8KEY30k4', $videos[3]->youtube_id);

        // Video 5
        $this->assertEquals(5, $videos[4]->sort_order);
        $this->assertEquals('bV6yfbEqGLw', $videos[4]->youtube_id);

        // Video 6
        $this->assertEquals(6, $videos[5]->sort_order);
        $this->assertEquals('7K_26WT8-uk', $videos[5]->youtube_id);

        // Video 7
        $this->assertEquals(7, $videos[6]->sort_order);
        $this->assertEquals('cJEyRaRa5-w', $videos[6]->youtube_id);

        // Video 8
        $this->assertEquals(8, $videos[7]->sort_order);
        $this->assertEquals('TFOfLMwuxTo', $videos[7]->youtube_id);
        $this->assertStringContainsString('വിവാഹ പൊരുത്തം അറിയേണ്ടത്', $videos[7]->title);
    }

    public function test_smart_youtube_id_parser_handles_various_formats(): void
    {
        $this->assertEquals('ZFzqmHgEDKQ', Video::parseYoutubeId('https://youtu.be/ZFzqmHgEDKQ?si=NxacyL_HjoelrMl0'));
        $this->assertEquals('xAo9vh-tMpw', Video::parseYoutubeId('https://www.youtube.com/watch?v=xAo9vh-tMpw'));
        $this->assertEquals('ugqn3yZzljU', Video::parseYoutubeId('https://www.youtube.com/embed/ugqn3yZzljU'));
        $this->assertEquals('x6X8KEY30k4', Video::parseYoutubeId('https://youtube.com/shorts/x6X8KEY30k4?feature=share'));
        $this->assertEquals('bV6yfbEqGLw', Video::parseYoutubeId('bV6yfbEqGLw'));
    }

    public function test_homepage_renders_videos_and_watch_all_button(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Video Gallery elements on homepage
        $response->assertSee('Vedic Astrology', false);
        $response->assertSee('Video Gallery', false);
        $response->assertSee('ZFzqmHgEDKQ', false);
        $response->assertSee('Featured Insight • Online Astro Counselling', false);
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

        // Cinematic branding
        $response->assertSee('VEDIC ASTROLOGY', false);
        $response->assertSee('CINEMA GALLERY', false);
        $response->assertSee('FEATURED PREMIERE', false);
        $response->assertSee('Watch Premiere Now', false);

        // Strict 2-column mobile grid check
        $response->assertSee('grid-cols-2', false);
        $response->assertSee('md:grid-cols-3', false);
        $response->assertSee('lg:grid-cols-4', false);

        // Video items present
        $response->assertSee('ZFzqmHgEDKQ', false);
        $response->assertSee('xAo9vh-tMpw', false);
        $response->assertSee('ugqn3yZzljU', false);
        $response->assertSee('x6X8KEY30k4', false);
        $response->assertSee('bV6yfbEqGLw', false);
        $response->assertSee('7K_26WT8-uk', false);
        $response->assertSee('cJEyRaRa5-w', false);
        $response->assertSee('TFOfLMwuxTo', false);

        // Cinema interactive controls: category filters, search & theater modal
        $response->assertSee('activeCategory', false);
        $response->assertSee('searchQuery', false);
        $response->assertSee('activeVideoModal', false);
        $response->assertSee('Cinema Theater', false);

        // VIP Consultation ticket box
        $response->assertSee('Direct Personal Astrology Consultation', false);
        $response->assertSee('Book Consultation Online', false);
    }

    public function test_individual_video_show_page_loads_with_player(): void
    {
        $response = $this->get('/videos/ZFzqmHgEDKQ');
        $response->assertStatus(200);

        $response->assertSee('Now Showing Premiere', false);
        $response->assertSee('Back to Cinema Video Gallery', false);
        $response->assertSee('ZFzqmHgEDKQ', false);
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
