<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Post</title>

    @vite('resources/css/app.css')

</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center p-6">

    <div class="w-full max-w-3xl">

        <!-- Card -->

        <div class="bg-white border border-gray-200 rounded-3xl shadow overflow-hidden">

            <!-- Header -->

            <div class="bg-blue-600 px-8 py-6">

                <div class="flex items-center justify-between">

                    <div>
                        <h1 class="text-3xl font-bold text-white">
                            ✏️ Edit Post
                        </h1>

                        <p class="text-blue-100 mt-1">
                            Update your post information
                        </p>
                    </div>

                    <a href="{{ route('posts.index') }}"
                        class="bg-white/10 hover:bg-white/20 text-white px-5 py-2 rounded-2xl transition">
                        ← Back
                    </a>

                </div>

            </div>

            <!-- Form -->

            <div class="p-8">

                <!-- Validation Errors -->

                @if ($errors->any())

                <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6">

                    <ul class="list-disc pl-5 space-y-1">

                        @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

                @endif

                <form method="POST" action="{{ route('posts.update', $post->id) }}" class="space-y-6">

                    @csrf
                    @method('PUT')

                    <!-- Title -->

                    <div>

                        <label class="block text-gray-700 font-semibold mb-3">
                            Post Title
                        </label>

                        <input type="text" name="title" value="{{ old('title', $post->title) }}"
                            placeholder="Enter post title..."
                            class="w-full bg-white border border-gray-300 text-gray-800 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    <!-- Content -->

                    <div>

                        <label class="block text-gray-700 font-semibold mb-3">
                            Post Content
                        </label>

                        <textarea name="content" rows="7" placeholder="Write your content here..."
                            class="w-full bg-white border border-gray-300 text-gray-800 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none">{{ old('content', $post->content) }}</textarea>
                    </div>

                    <!-- Image -->

                    <div>

                        <label class="block text-gray-700 font-semibold mb-3">
                            Post Image
                        </label>

                        @if($post->imageUrl())
                        <img src="{{ $post->imageUrl() }}" alt="post image"
                            class="h-32 w-32 object-cover rounded-2xl border border-gray-200 mb-3">
                        @endif

                        <input type="file" name="image" accept="image/*"
                            class="w-full bg-white border border-gray-300 text-gray-800 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    <!-- Buttons -->

                    <div class="flex flex-wrap items-center gap-4 pt-4">

                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-2xl shadow transition">
                            💾 Update Post
                        </button>

                        <a href="{{ route('posts.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-8 py-3 rounded-2xl transition">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</body>

</html>
