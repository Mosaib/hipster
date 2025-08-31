<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">

            <a href="{{ route('customer.dashboard') }}"
            class="px-4 py-2 dark:bg-gray-800 rounded-lg shadow bg-white">
                Dashboard
            </a>

            <form method="GET" action="{{ route('customer.products.index') }}" class="mt-4 flex flex-wrap gap-2 items-center">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search products..."
                    class="px-4 py-2 border rounded-lg w-64">
                <select name="sort_dir" class="px-4 py-2 border rounded-lg">
                    <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" selected {{ request('sort_dir') == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
                <select name="limit" class="px-4 py-2 border rounded-lg">
                    <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('limit') == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100</option>
                </select>
                <button type="submit"
                        class="px-4 py-2 bg-white dark:bg-gray-800 ml-3 shadow sm:rounded-lg">
                    Apply
                </button>
            </form>


        <div class="mt-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Category</th>
                        <th class="px-4 py-2">Image</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Stock</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td class="border px-4 py-2">
                                  {{ $product->id }}
                            </td>
                            <td class="border px-4 py-2">{{ $product->name }}
                            <td class="border px-4 py-2">{{ $product->category }}</td>

                            <td class="border px-4 py-2"><img src="{{ $product->image_url }}" class="w-20 h-20 object-cover"></td>
                            <td class="border px-4 py-2">{{ $product->price }}</td>
                            <td class="border px-4 py-2">{{ $product->stock }}</td>
                            <td class="border px-4 py-2">
                                <form action="{{ route('customer.orders.store', $product->id) }}" method="POST" class="flex gap-2">
                                    @csrf
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                        class="w-16 border rounded px-2">
                                    <button type="submit"
                                            class="px-3 py-1 shadow ml-2 text-green-600">
                                        Order
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
