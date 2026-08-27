<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Posts</title>

    @vite('resources/css/app.css')

</head>

<body class="bg-gray-100 min-h-screen p-8">

    <div class="max-w-7xl mx-auto">

        <!-- Header -->

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">

            <div>
                <h1 class="text-4xl font-bold text-gray-800">
                    👤 My Posts
                </h1>

                <p class="text-gray-500 mt-2">
                    Posts created by {{ auth()->user()->name }}
                </p>
            </div>

            <div class="flex gap-3 mt-4 md:mt-0">

                <a href="{{ route('dashboard') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-2xl font-semibold shadow transition">
                    🏠 Dashboard
                </a>

                @can('post-create')

                <a href="{{ route('posts.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-semibold shadow transition">
                    ➕ Create Post
                </a>

                @endcan

            </div>

        </div>

        <!-- Success Message -->

        @if(session('success'))

        <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl mb-6">
            {{ session('success') }}
        </div>

        @endif

        <!-- Stats Card -->

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow">
                <p class="text-gray-500 uppercase text-sm">
                    My Total Posts
                </p>

                <h2 class="text-5xl font-bold text-gray-800 mt-3">
                    {{ $posts->total() }}
                </h2>
            </div>

        </div>

        <!-- Posts Table -->

        <div class="bg-white border border-gray-200 rounded-3xl shadow overflow-hidden">

            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">
                    My Posts List
                </h2>
            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-gray-600 font-semibold">
                                ID
                            </th>

                            <th class="px-6 py-4 text-left text-gray-600 font-semibold">
                                Image
                            </th>

                            <th class="px-6 py-4 text-left text-gray-600 font-semibold">
                                Title
                            </th>

                            <th class="px-6 py-4 text-left text-gray-600 font-semibold">
                                Content
                            </th>

                            <th class="px-6 py-4 text-left text-gray-600 font-semibold">
                                Created Date
                            </th>

                            <th class="px-6 py-4 text-center text-gray-600 font-semibold">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($posts as $post)

                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">

                            <td class="px-6 py-4 text-gray-600">
                                #{{ $post->id }}
                            </td>

                            <td class="px-6 py-4">
                                @if($post->imageUrl())
                                <img src="{{ $post->imageUrl() }}" alt="post image"
                                    class="h-12 w-12 rounded-xl object-cover border border-gray-200">
                                @else
                                <span class="text-gray-400 text-sm">—</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-gray-800 font-semibold">
                                {{ $post->title }}
                            </td>

                            <td class="px-6 py-4 text-gray-500">
                                {{ Str::limit($post->content, 60) }}
                            </td>

                            <td class="px-6 py-4 text-gray-500">
                                {{ $post->created_at->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center flex-wrap gap-3">

                                    @can('post-view')
                                    <a href="{{ route('posts.show', $post->id) }}"
                                        class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-xl font-semibold transition">
                                        View
                                    </a>
                                    @endcan

                                    @can('post-edit')
                                    <a href="{{ route('posts.edit', $post->id) }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-xl font-semibold transition">
                                        Edit
                                    </a>
                                    @endcan

                                    @can('post-delete')

                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Delete this post?')"
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl font-semibold transition">
                                            Delete
                                        </button>
                                    </form>

                                    @endcan

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-400">
                                No Posts Found
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <!-- Pagination -->

            <div class="p-6 border-t border-gray-200 bg-white">
                {{ $posts->links() }}
            </div>

        </div>

    </div>

</body>

</html>
