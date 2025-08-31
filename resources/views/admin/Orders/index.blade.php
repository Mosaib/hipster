<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">

        <a href="{{ route('admin.dashboard') }}"
           class="px-4 py-2 dark:bg-gray-800 rounded-lg shadow bg-white">
            Dashboard
        </a>

        <div class="mt-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">User</th>
                        <th class="px-4 py-2">Product</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td class="border px-4 py-2">
                                  {{ $order->id }}
                            </td>
                            <td class="border px-4 py-2">{{ $order->user?->name ?? 'N/A' }}
                            <td class="border px-4 py-2">{{ $order->product?->name ?? 'N/A' }}</td>
                            <td class="border px-4 py-2">{{ $order->status }}</td>
                            <td class="border px-4 py-2">{{ $order->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
