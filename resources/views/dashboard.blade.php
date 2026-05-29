<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-3xl font-bold text-white">
                    Permission Dashboard
                </h2>

                <p class="text-gray-400 text-sm mt-1">
                    Laravel 12 Permission Driven UI Engine
                </p>
            </div>

            <div class="bg-gray-800 px-5 py-2 rounded-2xl shadow-lg">
                <span class="text-green-400 font-semibold">
                    👋 {{ auth()->user()->name }}
                </span>
            </div>

        </div>

    </x-slot>

    @php

        $totalPosts = \App\Models\Post::count();

        $latestPosts = \App\Models\Post::oldest()
                            ->paginate(3);

    @endphp

    <div class="min-h-screen bg-gradient-to-br from-black via-gray-900 to-gray-950 py-10">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Cards -->

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

                <!-- Total Posts -->

                <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 shadow-2xl hover:scale-105 transition duration-300">

                    <div class="flex justify-between items-center">

                        <div>

                            <p class="text-gray-400 uppercase text-sm">
                                Total Posts
                            </p>

                            <h2 class="text-5xl font-bold text-white mt-3">
                                {{ $totalPosts }}
                            </h2>

                        </div>

                        <div class="bg-blue-500/20 p-5 rounded-2xl text-4xl">
                            📝
                        </div>

                    </div>

                </div>

                <!-- User -->

                <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 shadow-2xl hover:scale-105 transition duration-300">

                    <div class="flex justify-between items-center">

                        <div>

                            <p class="text-gray-400 uppercase text-sm">
                                Logged User
                            </p>

                            <h2 class="text-3xl font-bold text-white mt-3">
                                {{ auth()->user()->name }}
                            </h2>

                        </div>

                        <div class="bg-green-500/20 p-5 rounded-2xl text-4xl">
                            👤
                        </div>

                    </div>

                </div>

                <!-- Role -->

                <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 shadow-2xl hover:scale-105 transition duration-300">

                    <div class="flex justify-between items-center">

                        <div>

                            <p class="text-gray-400 uppercase text-sm">
                                User Role
                            </p>

                            <h2 class="text-3xl font-bold text-white mt-3">

                                @if(auth()->user()->roles->count())

                                    {{ auth()->user()->roles->first()->name }}

                                @else

                                    No Role

                                @endif

                            </h2>

                        </div>

                        <div class="bg-purple-500/20 p-5 rounded-2xl text-4xl">
                            🔐
                        </div>

                    </div>

                </div>

            </div>

            <!-- Quick Actions -->

            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-8 shadow-2xl mb-10">

                <div class="flex items-center justify-between mb-6">

                    <h2 class="text-2xl font-bold text-white">
                        Quick Actions
                    </h2>

                    <span class="text-gray-500 text-sm">
                        Manage your application
                    </span>

                </div>

                <div class="flex flex-wrap gap-5">

                    @can('post-create')

                    <a
                        href="{{ route('posts.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-2xl text-white font-semibold shadow-lg transition"
                    >
                        ➕ Create Post
                    </a>

                    @endcan

                    <a
                        href="{{ route('posts.index') }}"
                        class="bg-gray-800 hover:bg-gray-700 px-6 py-3 rounded-2xl text-white font-semibold shadow-lg transition"
                    >
                        📋 View Posts
                    </a>

                </div>

            </div>

            <!-- Posts Table -->

            <div class="bg-gray-900 border border-gray-800 rounded-3xl shadow-2xl overflow-hidden">

                <div class="p-6 border-b border-gray-800">

                    <h2 class="text-2xl font-bold text-white">
                        Latest Posts
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
                                    Created
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($latestPosts as $post)

                                <tr class="border-b border-gray-800 hover:bg-gray-800 transition">

                                    <td class="px-6 py-4 text-gray-300">
                                        #{{ $post->id }}
                                    </td>

                                    <td class="px-6 py-4 text-white font-medium">
                                        {{ $post->title }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-400">
                                        {{ $post->created_at->format('d M Y') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="3" class="text-center py-10 text-gray-500">
                                        No Posts Available
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <!-- Pagination -->

                <div class="p-6 bg-gray-900 border-t border-gray-800">

                    {{ $latestPosts->links() }}

                </div>

            </div>

        </div>

    </div>

</x-app-layout>