<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use RuntimeException;

class PostReportController extends Controller
{
    public function index(Request $request): View
    {
        return view('posts.reports.index', $this->getReportData($request));
    }

    public function exportPdf(Request $request)
    {
        $data = $this->getReportData($request);

        return Pdf::loadView('posts.reports.pdf', $data)
            ->setPaper('a4', 'portrait')
            ->download('blog_posts_report.pdf');
    }

    public function exportCsv(Request $request)
    {
        $posts = $this->getReportData($request)['posts'];

        return response()->streamDownload(function () use ($posts): void {
            $file = fopen('php://output', 'w');

            if ($file === false) {
                throw new RuntimeException('Unable to open the CSV output stream.');
            }

            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, ['ID', 'Title', 'Body', 'Created At'], ',', '"', '');

            foreach ($posts as $post) {
                fputcsv($file, [
                    $post->id,
                    $this->csvText($post->title),
                    $this->csvText($post->body),
                    $post->created_at->format('Y-m-d H:i:s'),
                ], ',', '"', '');
            }

            fclose($file);
        }, 'blog_posts_report.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * @return array{
     *     posts: Collection<int, Post>,
     *     totalPosts: int,
     *     startDate: string|null,
     *     endDate: string|null,
     *     generatedAt: string
     * }
     */
    private function getReportData(Request $request): array
    {
        $endDateRules = ['nullable', 'date_format:Y-m-d'];

        if ($request->filled('start_date')) {
            $endDateRules[] = 'after_or_equal:start_date';
        }

        $validated = $request->validate([
            'start_date' => ['nullable', 'date_format:Y-m-d'],
            'end_date' => $endDateRules,
        ]);

        $startDate = $validated['start_date'] ?? null;
        $endDate = $validated['end_date'] ?? null;

        $query = Post::query();

        if ($startDate !== null) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate !== null) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $posts = $query->latest()->orderByDesc('id')->get();

        return [
            'posts' => $posts,
            'totalPosts' => $posts->count(),
            'startDate' => $startDate,
            'endDate' => $endDate,
            'generatedAt' => now()->format('Y-m-d H:i:s'),
        ];
    }

    private function csvText(string $value): string
    {
        if (preg_match('/^[\s\x{FEFF}]*[=+\-@]/u', $value) === 1) {
            return "'".$value;
        }

        return $value;
    }
}