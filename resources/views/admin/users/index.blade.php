<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">

            <a href="{{ route('admin.dashboard') }}"
            class="px-4 py-2 dark:bg-gray-800 rounded-lg shadow bg-white">
                Dashboard
            </a>

        <div class="mt-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
            <table class="w-full" stye="width: 100%">
                <thead>
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">User Type</th>
                        <th class="px-4 py-2">Create At</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="border px-4 py-2">{{ $user->id }}</td>
                            <td class="border px-4 py-2">{{ $user->name }}
                            <td class="border px-4 py-2">{{ $user->email }}</td>
                            <td class="border px-4 py-2">{{ $user->user_type }}</td>
                            <td class="border px-4 py-2">{{ $user->created_at }}</td>
                            <td class="border px-4 py-2">
                                @if($user->is_online)
                                    <span class="px-2 py-1 text-green-600 rounded-full text-xs">Online</span>
                                @else
                                    <span class="px-2 py-1 text-gray-600 rounded-full text-xs">Offline</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
