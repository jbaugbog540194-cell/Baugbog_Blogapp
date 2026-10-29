<x-posts-layout>
    <x-slot name="header">
        <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-indigo-700">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 1 1 1.06 1.06l-3.22 3.22h10.69A.75.75 0 0 1 17 10Z" clip-rule="evenodd" />
            </svg>
            Back to posts
        </a>
        <div class="mt-5 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div class="min-w-0">
                <p class="mb-2 text-xs font-bold uppercase tracking-[0.18em] text-indigo-600">Post details</p>
                <h1 class="break-words text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">{{ $post->title }}</h1>
                <p class="mt-3 text-sm text-slate-500">Last updated {{ $post->updated_at->diffForHumans() }}</p>
            </div>
            <a href="{{ route('posts.edit', $post) }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="m13.7 3.3 3 3a1 1 0 0 1 0 1.4l-8.8 8.8-4 1 1-4 8.8-8.8a1 1 0 0 1 1.4 0Z" />
                </svg>
                Edit post
            </a>
        </div>
    </x-slot>

    <article class="mx-auto max-w-4xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-200/50">
        <div class="border-b border-slate-100 px-6 py-4 sm:px-10">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Article</p>
        </div>
        <div class="px-6 py-8 sm:px-10 sm:py-10">
            <p class="whitespace-pre-wrap text-base leading-8 text-slate-700">{{ $post->body }}</p>
        </div>
    </article>
</x-posts-layout>
