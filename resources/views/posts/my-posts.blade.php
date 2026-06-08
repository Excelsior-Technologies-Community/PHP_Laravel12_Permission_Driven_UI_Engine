<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Posts</title>

    @vite('resources/css/app.css')

</head>

<body class="bg-gradient-to-br from-black via-gray-900 to-gray-950 min-h-screen p-8">

    <div class="max-w-7xl mx-auto">

        <!-- Header -->

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">

            <div>

                <h1 class="text-4xl font-bold text-white">
                    👤 My Posts
                </h1>

                <p class="text-gray-400 mt-2">
                    Posts created by {{ auth()->user()->name }}
                </p>

            </div>

            <div class="flex gap-3 mt-4 md:mt-0">

                <a
                    href="{{ route('dashboard') }}"
                    class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg transition"
                >
                    🏠 Dashboard
                </a>

                @can('post-create')

                <a
                    href="{{ route('posts.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg transition"
                >
                    ➕ Create Post
                </a>

                @endcan

            </div>

        </div>

        <!-- Success Message -->

        @if(session('success'))

            <div class="bg-green-500/20 border border-green-500 text-green-300 px-5 py-4 rounded-2xl mb-6">

                {{ session('success') }}

            </div>

        @endif

        <!-- Stats Card -->

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 shadow-2xl">

                <p class="text-gray-400 uppercase text-sm">
                    My Total Posts
                </p>

                <h2 class="text-5xl font-bold text-white mt-3">
                    {{ $posts->total() }}
                </h2>

            </div>

        </div>

        <!-- Posts Table -->

        <div class="bg-gray-900 border border-gray-800 rounded-3xl shadow-2xl overflow-hidden">

            <div class="p-6 border-b border-gray-800">

                <h2 class="text-2xl font-bold text-white">
                    My Posts List
                </h2>

            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-gray-800">

                        <tr>

                            <th class="px-6 py-4 text-left text-gray-300">
                                ID
                            </th>

                            <th class="px-6 py-4 text-left text-gray-300">
                                Title
                            </th>

                            <th class="px-6 py-4 text-left text-gray-300">
                                Content
                            </th>

                            <th class="px-6 py-4 text-left text-gray-300">
                                Created Date
                            </th>

                            <th class="px-6 py-4 text-center text-gray-300">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($posts as $post)

                            <tr class="border-b border-gray-800 hover:bg-gray-800 transition">

                                <td class="px-6 py-4 text-gray-300">
                                    #{{ $post->id }}
                                </td>

                                <td class="px-6 py-4 text-white font-semibold">
                                    {{ $post->title }}
                                </td>

                                <td class="px-6 py-4 text-gray-400">
                                    {{ Str::limit($post->content, 60) }}
                                </td>

                                <td class="px-6 py-4 text-gray-400">
                                    {{ $post->created_at->format('d M Y') }}
                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex justify-center gap-3">

                                        @can('post-edit')

                                        <a
                                            href="{{ route('posts.edit', $post->id) }}"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded-xl font-semibold transition"
                                        >
                                            Edit
                                        </a>

                                        @endcan

                                        @can('post-delete')

                                        <form
                                            action="{{ route('posts.destroy', $post->id) }}"
                                            method="POST"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                onclick="return confirm('Delete this post?')"
                                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl font-semibold transition"
                                            >
                                                Delete
                                            </button>

                                        </form>

                                        @endcan

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center py-10 text-gray-500">

                                    No Posts Found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <!-- Pagination -->

            <div class="p-6 border-t border-gray-800 bg-gray-900">

                {{ $posts->links() }}

            </div>

        </div>

    </div>

</body>

</html>