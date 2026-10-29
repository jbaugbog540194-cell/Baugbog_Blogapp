<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col gap-6 p-6 sm:flex-row sm:items-center sm:justify-between sm:p-8">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 6.75h12M8 12h12M8 17.25h12M4.25 6.75h.01M4.25 12h.01m-.01 5.25h.01" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-indigo-600">Content management</p>
                            <h3 class="mt-1 text-xl font-bold tracking-tight text-slate-900">Posts</h3>
                            <p class="mt-1 max-w-xl text-sm leading-6 text-slate-500">Create, view, edit, and manage your blog posts from one place.</p>
                            <p class="mt-3 text-sm font-medium text-slate-700">
                                {{ $postsCount }} {{ \Illuminate\Support\Str::plural('post', $postsCount) }} in your workspace
                            </p>
                        </div>
                    </div>
                    <div class="flex shrink-0 flex-col gap-3 sm:flex-row">
                        <a href="{{ route('posts.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Manage posts
                        </a>
                        <a href="{{ route('posts.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M10 4a.75.75 0 0 1 .75.75v4.5h4.5a.75.75 0 0 1 0 1.5h-4.5v4.5a.75.75 0 0 1-1.5 0v-4.5h-4.5a.75.75 0 0 1 0-1.5h4.5v-4.5A.75.75 0 0 1 10 4Z" />
                            </svg>
                            New post
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
