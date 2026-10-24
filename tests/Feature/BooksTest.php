<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_seeded_books_contain_exactly_dr_raja_varma_seven_works()
    {
        $books = Book::orderBy('sort_order', 'asc')->get();

        $this->assertCount(7, $books);

        $expected = [
            1 => ['title' => 'മനോരഥം (Manoratham)', 'price' => 100],
            2 => ['title' => 'രണ്ടാമൂഴം (Randamoozham)', 'price' => 120],
            3 => ['title' => 'ത്രിമാനം (Thrimanam)', 'price' => 120],
            4 => ['title' => 'ചതുരംഗം (Chathurangam)', 'price' => 150],
            5 => ['title' => 'പഞ്ചാമൃതം (Panchamrutham)', 'price' => 150],
            6 => ['title' => 'ഷഷ്ടാംഗം (Shashtangam)', 'price' => 150],
            7 => ['title' => 'രാജഗീതം (Rajageetham - Audio CD)', 'price' => 100],
        ];

        foreach ($books as $book) {
            $this->assertEquals($expected[$book->sort_order]['title'], $book->title);
            $this->assertEquals($expected[$book->sort_order]['price'], (int) $book->price);
            $this->assertStringContainsString('https://wa.me/917907052160', $book->whats_app_order_url);
            $this->assertFileExists(public_path($book->cover_image));
        }
    }

    public function test_homepage_renders_books_section_with_prices_and_whatsapp_buttons()
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('id="books"', false);
        $response->assertSee('Books & Works', false);
        $response->assertSee('മനോരഥം (Manoratham)');
        $response->assertSee('ഷഷ്ടാംഗം (Shashtangam)');
        $response->assertSee('രാജഗീതം (Rajageetham - Audio CD)');
        $response->assertSee('₹100');
        $response->assertSee('₹120');
        $response->assertSee('₹150');
        $response->assertSee('https://wa.me/917907052160', false);
        $response->assertSee('https://online.fliphtml5.com/kvuzr/xfdb/#p=1', false);
    }

    public function test_admin_can_manage_books()
    {
        $admin = User::first() ?? User::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.books.index'));
        $response->assertStatus(200);
        $response->assertSee('Books &amp; Publications Management', false);
        $response->assertSee('മനോരഥം (Manoratham)');

        // Test editing a book
        $book = Book::first();
        $response = $this->actingAs($admin)->get(route('admin.books.edit', $book));
        $response->assertStatus(200);
        $response->assertSee($book->title);

        // Test updating
        $response = $this->actingAs($admin)->put(route('admin.books.update', $book), [
            'title' => 'Updated Title',
            'price' => 199.00,
            'description' => 'Updated description test',
            'sort_order' => $book->sort_order,
            'cover_image' => $book->cover_image,
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('admin.books.index'));
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Updated Title',
            'price' => 199.00,
        ]);
    }
}
