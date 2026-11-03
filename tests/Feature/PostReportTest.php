<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_report_page_lists_posts_and_filters_inclusive_date_range(): void
    {
        $before = Post::create(['title' => 'Before range', 'body' => 'Earlier post']);
        $before->forceFill([
            'created_at' => '2025-03-09 23:59:59',
            'updated_at' => '2025-03-09 23:59:59',
        ])->save();

        $inside = Post::create(['title' => 'Inside range', 'body' => 'Matching post']);
        $inside->forceFill([
            'created_at' => '2025-03-10 12:00:00',
            'updated_at' => '2025-03-10 12:00:00',
        ])->save();

        $after = Post::create(['title' => 'After range', 'body' => 'Later post']);
        $after->forceFill([
            'created_at' => '2025-03-11 00:00:00',
            'updated_at' => '2025-03-11 00:00:00',
        ])->save();

        $this->get(route('posts.reports.index', [
            'start_date' => '2025-03-10',
            'end_date' => '2025-03-10',
        ]))
            ->assertOk()
            ->assertSeeText('Inside range')
            ->assertDontSeeText('Before range')
            ->assertDontSeeText('After range')
            ->assertSeeText('1 post');

        $this->get(route('posts.reports.index', ['start_date' => '2025-03-10']))
            ->assertOk()
            ->assertSeeText('Inside range')
            ->assertSeeText('After range')
            ->assertDontSeeText('Before range');

        $this->get(route('posts.reports.index', ['end_date' => '2025-03-09']))
            ->assertOk()
            ->assertSeeText('Before range')
            ->assertDontSeeText('Inside range')
            ->assertDontSeeText('After range');
    }

    public function test_report_rejects_an_end_date_before_the_start_date(): void
    {
        $this->from(route('posts.reports.index'))
            ->get(route('posts.reports.index', [
                'start_date' => '2025-03-11',
                'end_date' => '2025-03-10',
            ]))
            ->assertRedirect(route('posts.reports.index'))
            ->assertSessionHasErrors('end_date');
    }

    public function test_csv_export_uses_the_report_filter_and_escapes_formula_values(): void
    {
        $post = Post::create([
            'title' => '=SUM(1,1)',
            'body' => 'Report body',
        ]);
        $post->forceFill([
            'created_at' => '2025-03-10 12:00:00',
            'updated_at' => '2025-03-10 12:00:00',
        ])->save();

        $response = $this->get(route('posts.reports.csv', [
            'start_date' => '2025-03-10',
            'end_date' => '2025-03-10',
        ]));

        $response->assertOk()->assertDownload('blog_posts_report.csv');

        $csv = $response->streamedContent();

        $rows = preg_split('/\r\n|\r|\n/', ltrim($csv, "\xEF\xBB\xBF"));

        $this->assertSame(['ID', 'Title', 'Body', 'Created At'], str_getcsv($rows[0]));
        $this->assertSame((string) $post->id, str_getcsv($rows[1])[0]);
        $this->assertSame("'=SUM(1,1)", str_getcsv($rows[1])[1]);
        $this->assertSame('Report body', str_getcsv($rows[1])[2]);
    }
}
