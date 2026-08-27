<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Management</title>

    @vite('resources/css/app.css')

</head>

<body class="bg-gray-100 min-h-screen p-8">

    <div class="max-w-7xl mx-auto">

        <!-- Header -->

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">

            <div>
                <h1 class="text-4xl font-bold text-gray-800">
                    👥 User Management
                </h1>

                <p class="text-gray-500 mt-2">
                    Manage users and assign roles
                </p>
            </div>

            <a href="{{ route('dashboard') }}"
                class="mt-4 md:mt-0 bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-2xl font-semibold shadow transition">
                🏠 Dashboard
            </a>

        </div>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl mb-6">
            {{ session('success') }}
        </div>
        @endif

        <!-- Table -->

        <div class="bg-white border border-gray-200 rounded-3xl shadow overflow-hidden">

            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">
                    All Users ({{ $users->count() }})
                </h2>
            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-gray-600 font-semibold">
                                User
                            </th>

                            <th class="px-6 py-4 text-left text-gray-600 font-semibold">
                                Email
                            </th>

                            <th class="px-6 py-4 text-left text-gray-600 font-semibold">
                                Roles
                            </th>

                            <th class="px-6 py-4 text-center text-gray-600 font-semibold">
                                Permissions
                            </th>

                            <th class="px-6 py-4 text-center text-gray-600 font-semibold">
                                Posts
                            </th>

                            <th class="px-6 py-4 text-left text-gray-600 font-semibold">
                                Set Role
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($users as $user)

                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">

                            <!-- User -->

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-gray-800 font-semibold">
                                            {{ $user->name }}
                                            @if($user->id === auth()->id())
                                            <span class="ml-1 text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">You</span>
                                            @endif
                                        </p>
                                        <p class="text-gray-400 text-xs">
                                            #{{ $user->id }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <!-- Email -->

                            <td class="px-6 py-4 text-gray-600">
                                {{ $user->email }}
                            </td>

                            <!-- Roles -->

                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    @forelse($user->roles as $role)
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ $role->name }}
                                    </span>
                                    @empty
                                    <span class="text-gray-400 text-sm">No role</span>
                                    @endforelse
                                </div>
                            </td>

                            <!-- Permissions -->

                            <td class="px-6 py-4 text-center">
                                <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $user->getAllPermissions()->count() }}
                                </span>
                            </td>

                            <!-- Posts -->

                            <td class="px-6 py-4 text-center text-gray-700 font-semibold">
                                {{ $user->posts_count }}
                            </td>

                            <!-- Set Role -->

                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('users.assignRole', $user) }}" class="flex items-center gap-2">
                                    @csrf
                                    <select name="role"
                                        class="bg-white border border-gray-300 text-gray-800 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @foreach($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ $user->roles->contains('name', $role->name) ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition">
                                        Save
                                    </button>
                                </form>
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-400">
                                No users found.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>

</html>
