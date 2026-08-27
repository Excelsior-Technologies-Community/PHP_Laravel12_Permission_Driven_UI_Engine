<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white w-full max-w-xl rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            Create New Post
        </h1>

        <form method="POST" action="{{ route('posts.store') }}" class="space-y-5">
            @csrf

            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Title
                </label>
                <input
                    type="text"
                    name="title"
                    placeholder="Enter post title"
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Content -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Content
                </label>
                <textarea
                    name="content"
                    rows="5"
                    placeholder="Write your post content..."
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                ></textarea>
            </div>

            <!-- Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Image (optional)
                </label>
                <input
                    type="file"
                    name="image"
                    accept="image/*"
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Button -->
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition"
                >
                    Save Post
                </button>
            </div>
        </form>
    </div>

</body>
</html>