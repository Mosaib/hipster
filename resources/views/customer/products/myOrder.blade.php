<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Order') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">

        <a href="{{ route('customer.dashboard') }}"
           class="px-4 py-2 dark:bg-gray-800 rounded-lg shadow bg-white">
            Dashboard
        </a>

        <div class="mt-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Product</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Quantity</th>
                        <th class="px-4 py-2">Order At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="text-center">
                            <td class="border px-4 py-2">
                                  {{ $order->id }}
                            </td>
                            <td class="border px-4 py-2">{{ $order->product?->name ?? 'N/A' }}</td>

                            <td class="border px-4 py-2">
                                <span class="px-2 py-1 rounded
                                    @if($order->status == 'pending')   text-red-600
                                    @elseif($order->status == 'shipped') text-black-600
                                    @elseif($order->status == 'delivered') text-green-600
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="border px-4 py-2">{{ $order->quantity }}</td>
                            <td class="border px-4 py-2">{{ $order->created_at->format('d M Y - H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
