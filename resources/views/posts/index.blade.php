<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Posts</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-lg p-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Posts
            </h2>

            @can('post-create')
                <a
                    href="{{ route('posts.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition"
                >
                    ➕ Create Post
                </a>
            @endcan
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-4 py-3 text-sm font-semibold text-gray-700">
                            Title
                        </th>
                        <th class="text-right px-4 py-3 text-sm font-semibold text-gray-700">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse($posts as $post)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-800">
                                {{ $post->title }}
                            </td>

                            <td class="px-4 py-3 text-right space-x-3">
                                @can('post-edit')
                                    <a
                                        href="#"
                                        class="text-blue-600 hover:text-blue-800 font-medium"
                                    >
                                        Edit
                                    </a>
                                @endcan

                                @can('post-delete')
                                    <a
                                        href="#"
                                        class="text-red-600 hover:text-red-800 font-medium"
                                    >
                                        Delete
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-4 py-6 text-center text-gray-500">
                                No posts found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>