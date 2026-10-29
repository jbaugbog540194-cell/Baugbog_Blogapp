<x-posts-layout>
    <x-slot name="header">
        <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-indigo-700">
            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 1 1 1.06 1.06l-3.22 3.22h10.69A.75.75 0 0 1 17 10Z" clip-rule="evenodd" />
            </svg>
            Back to posts
        </a>
        <h1 class="mt-5 text-3xl font-bold tracking-tight text-slate-900">Edit post</h1>
        <p class="mt-2 text-sm text-slate-500">Make changes to “{{ $post->title }}”.</p>
    </x-slot>

    <div class="mx-auto max-w-3xl">
        <form action="{{ route('posts.update', $post) }}" method="POST" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-200/50">
            @csrf
            @method('PUT')
            <div class="space-y-6 p-5 sm:p-8">
                <div>
                    <label for="title" class="block text-sm font-semibold text-slate-800">Post title</label>
                    <p class="mt-1 text-sm text-slate-500">Choose a clear title that tells readers what this is about.</p>
                    <input id="title" name="title" type="text" value="{{ old('title', $post->title) }}" required maxlength="255"
                        class="mt-3 block w-full rounded-xl border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('title')
                        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="body" class="block text-sm font-semibold text-slate-800">Content</label>
                    <p class="mt-1 text-sm text-slate-500">Edit the full text of your post below.</p>
                    <textarea id="body" name="body" rows="12" required
                        class="mt-3 block w-full resize-y rounded-xl border-slate-300 px-4 py-3 text-sm leading-6 text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('body', $post->body) }}</textarea>
                    @error('body')
                        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50/70 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-8">
                <a href="{{ route('posts.index') }}" class="text-center text-sm font-medium text-slate-600 transition hover:text-slate-900">Cancel</a>
                <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save changes</button>
            </div>
        </form>
    </div>
</x-posts-layout>
