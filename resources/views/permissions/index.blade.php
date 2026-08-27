<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Permission Management</title>

    @vite('resources/css/app.css')

</head>

<body class="bg-gray-100 min-h-screen p-8">

    <div class="max-w-7xl mx-auto">

        <!-- Header -->

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">

            <div>
                <h1 class="text-4xl font-bold text-gray-800">
                    🔐 Permission Management
                </h1>
                <p class="text-gray-500 mt-2">
                    Create permissions and assign them to roles
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Create Permission -->

            <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">
                    ➕ New Permission
                </h2>

                <form method="POST" action="{{ route('permissions.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Permission Name
                        </label>
                        <input type="text" name="name" placeholder="e.g. post-publish"
                            class="w-full bg-white border border-gray-300 text-gray-800 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    @error('name')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-2xl w-full transition">
                        Create Permission
                    </button>
                </form>
            </div>

            <!-- Assign To Role -->

            <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">
                    🔗 Assign To Role
                </h2>

                <form id="assign-form" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Permission
                        </label>
                        <select id="assign-permission" name="permission_id"
                            class="w-full bg-white border border-gray-300 text-gray-800 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Role
                        </label>
                        <select name="role"
                            class="w-full bg-white border border-gray-300 text-gray-800 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-2xl w-full transition">
                        Assign Permission
                    </button>
                </form>
            </div>

            <!-- Permissions List -->

            <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">
                    📋 Permissions ({{ $permissions->count() }})
                </h2>

                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse($permissions as $permission)
                    <div class="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3">
                        <div>
                            <p class="text-gray-800 font-semibold">{{ $permission->name }}</p>
                            <p class="text-gray-500 text-xs">
                                Roles: {{ $permission->roles->pluck('name')->join(', ') ?: 'none' }}
                            </p>
                        </div>

                        <form method="POST" action="{{ route('permissions.destroy', $permission->id) }}">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Delete permission {{ $permission->name }}?')"
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-xl text-sm font-semibold transition">
                                Delete
                            </button>
                        </form>
                    </div>
                    @empty
                    <p class="text-gray-400">No permissions yet.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

    <script>
        const form = document.getElementById('assign-form');
        const select = document.getElementById('assign-permission');

        function updateAction() {
            form.action = `/permissions/${select.value}/assign-role`;
        }

        select.addEventListener('change', updateAction);
        updateAction();
    </script>

</body>

</html>
