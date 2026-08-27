<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $post->title }}</title>

    @vite('resources/css/app.css')

</head>

<body class="bg-gray-100 min-h-screen p-8">

    <div class="max-w-3xl mx-auto">

        <div class="bg-white border border-gray-200 rounded-3xl shadow overflow-hidden">

            <!-- Header -->

            <div class="bg-blue-600 px-8 py-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">
                        {{ $post->title }}
                    </h1>
                    <p class="text-blue-100 mt-1">
                        By {{ $post->user->name ?? 'System' }}
                        · {{ $post->created_at->format('d M Y') }}
                    </p>
                </div>

                <a href="{{ route('posts.index') }}"
                    class="bg-white/10 hover:bg-white/20 text-white px-5 py-2 rounded-2xl transition">
                    ← Back
                </a>
            </div>

            <!-- Body -->

            <div class="p-8">

                @if($post->imageUrl())
                <img src="{{ $post->imageUrl() }}"
                    alt="post image"
                    class="w-full h-64 object-cover rounded-2xl border border-gray-200 mb-6">
                @endif

                @if($post->trashed())
                <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6">
                    This post is soft-deleted.
                </div>
                @endif

                <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $post->content }}
                </p>

                <div class="flex flex-wrap gap-4 pt-8">

                    @can('post-edit')
                    <a href="{{ route('posts.edit', $post->id) }}"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-2xl font-semibold transition">
                        ✏️ Edit
                    </a>
                    @endcan

                    @can('post-delete')

                    @if($post->trashed())
                    <form action="{{ route('posts.restore', $post->id) }}" method="POST">
                        @csrf
                        <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-2xl font-semibold transition">
                            ♻️ Restore
                        </button>
                    </form>
                    @else
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Delete this post?')"
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-2xl font-semibold transition">
                            🗑️ Delete
                        </button>
                    </form>
                    @endif

                    @endcan

                </div>

            </div>

        </div>

    </div>

</body>

</html>
