<x-posts-layout>
    <x-slot name="header">
        <div>
            <p class="mb-2 text-xs font-bold uppercase tracking-[0.18em] text-indigo-600">Your content</p>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Post reports</h1>
            <p class="mt-2 text-sm text-slate-500">Filter posts by creation date and export the results.</p>
        </div>
    </x-slot>

    @if ($errors->any())
        <div role="alert" class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
            <p class="font-semibold">Please correct the following:</p>
            <ul class="mt-2 list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm shadow-slate-200/50 sm:p-6">
        <form action="{{ route('posts.reports.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div>
                <label for="start_date" class="mb-1.5 block text-sm font-medium text-slate-700">Start date</label>
                <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                    class="rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="end_date" class="mb-1.5 block text-sm font-medium text-slate-700">End date</label>
                <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                    class="rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <button type="submit" class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                Generate report
            </button>
            <a href="{{ route('posts.reports.index') }}" class="px-2 py-2.5 text-sm font-semibold text-slate-600 hover:text-indigo-700">
                Reset filters
            </a>
        </form>
    </section>

    <section class="mb-6 flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm shadow-slate-200/50 sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <p class="text-sm text-slate-500">
                Period: <span class="font-medium text-slate-700">{{ $startDate ?: 'Beginning' }} to {{ $endDate ?: 'Present' }}</span>
            </p>
            <p class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                {{ $totalPosts }} <span class="text-base font-medium text-slate-500">{{ \Illuminate\Support\Str::plural('post', $totalPosts) }}</span>
            </p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('posts.reports.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Export PDF
            </a>
            <a href="{{ route('posts.reports.csv', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                class="inline-flex items-center justify-center rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-semibold text-emerald-800 transition hover:bg-emerald-100">
                Export CSV
            </a>
        </div>
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-200/50">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th scope="col" class="px-5 py-3">ID</th>
                        <th scope="col" class="px-5 py-3">Title</th>
                        <th scope="col" class="px-5 py-3">Body preview</th>
                        <th scope="col" class="px-5 py-3">Created date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($posts as $post)
                        <tr>
                            <td class="whitespace-nowrap px-5 py-4">{{ $post->id }}</td>
                            <td class="min-w-40 px-5 py-4 font-medium text-slate-900">{{ $post->title }}</td>
                            <td class="min-w-56 px-5 py-4">{{ \Illuminate\Support\Str::limit($post->body, 100) }}</td>
                            <td class="whitespace-nowrap px-5 py-4">{{ $post->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-slate-500">No posts found for the selected dates.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <a href="{{ route('posts.index') }}" class="mt-6 inline-flex text-sm font-semibold text-indigo-700 hover:text-indigo-900">
        &larr; Back to posts
    </a>
</x-posts-layout>
