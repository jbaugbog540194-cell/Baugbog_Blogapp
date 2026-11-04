<x-posts-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="mb-2 text-xs font-bold uppercase tracking-[0.18em] text-red-700">Your content</p>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Posts</h1>
                <p class="mt-2 text-sm text-slate-500">Create, manage, and publish your blog content.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('posts.reports.index') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-gray-100 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    View reports
                </a>
                <a href="{{ route('posts.create') }}" class="inline-flex items-center justify-center gap-2 self-start rounded-xl bg-red-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-red-900/20 transition hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:self-auto">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M10 4a.75.75 0 0 1 .75.75v4.5h4.5a.75.75 0 0 1 0 1.5h-4.5v4.5a.75.75 0 0 1-1.5 0v-4.5h-4.5a.75.75 0 0 1 0-1.5h4.5v-4.5A.75.75 0 0 1 10 4Z" />
                    </svg>
                    New post
                </a>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div role="status" class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
            <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.78-9.97a.75.75 0 0 0-1.06-1.06l-3.6 3.6-1.84-1.84a.75.75 0 0 0-1.06 1.06l2.37 2.37a.75.75 0 0 0 1.06 0l4.13-4.13Z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <section class="overflow-hidden rounded-xl border border-gray-300 bg-gray-50">
        <div class="flex items-center justify-between border-b border-gray-300 px-5 py-4 sm:px-6">
            <div>
                <h2 class="font-semibold text-slate-900">All posts</h2>
            </div>
            <span class="rounded-full bg-gray-200 px-3 py-1 text-xs font-semibold text-slate-600">{{ $posts->count() }} {{ \Illuminate\Support\Str::plural('post', $posts->count()) }}</span>
        </div>

        @if ($posts->isEmpty())
            <div class="px-6 py-16 text-center sm:py-20">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-red-100 text-red-700">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75h6.75A2.25 2.25 0 0 1 21 9v9.75A2.25 2.25 0 0 1 18.75 21H5.25A2.25 2.25 0 0 1 3 18.75V5.25A2.25 2.25 0 0 1 5.25 3H15m-3 3.75h6.75M12 11.25h6.75M6.75 12h1.5m-1.5 3h10.5m-10.5 3h7.5" />
                    </svg>
                </div>
                <h3 class="mt-5 text-base font-semibold text-slate-900">No posts yet</h3>
                <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500">Get started by writing your first post. It will show up here when you save it.</p>
                <a href="{{ route('posts.create') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-red-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-800">
                    <span aria-hidden="true">+</span> Create your first post
                </a>
            </div>
        @else
            <div class="divide-y divide-gray-300">
                @foreach ($posts as $post)
                    <article class="flex flex-col gap-4 px-5 py-5 transition hover:bg-gray-200 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <div class="min-w-0 flex-1">
                            <a href="{{ route('posts.show', $post) }}" class="font-semibold text-slate-900 transition hover:text-red-700">{{ $post->title }}</a>
                            <p class="mt-1.5 line-clamp-2 text-sm leading-6 text-slate-500">{{ $post->body }}</p>
                            <p class="mt-2 text-xs text-slate-400">Updated {{ $post->updated_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex shrink-0 items-center gap-2">
                            <a href="{{ route('posts.show', $post) }}" class="rounded-lg border border-gray-300 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-gray-300 hover:text-red-800">View</a>
                            <a href="{{ route('posts.edit', $post) }}" class="rounded-lg border border-gray-300 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-gray-300 hover:text-red-800">Edit</a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Delete this post? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg border border-red-200 px-3 py-2 text-sm font-medium text-red-700 transition hover:bg-red-100">Delete</button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</x-posts-layout>
