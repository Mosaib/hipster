<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
           {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <a href="{{ route('admin.products.index') }}"
           class="px-4 py-2 dark:bg-gray-800 rounded-lg shadow bg-white">
            Manage Products
        </a>

        <div class="mt-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
            <p class="mt-2"><strong>Description:</strong>{{ $product->description }}</p>

            <div class="mt-4">
                <img src="{{ $product->image_url }}"
                     class="w-40 h-40 object-cover"
                     alt="Product Image">
            </div>

            <p class="mt-4"><strong>Category:</strong> {{ $product->category }}</p>
            <p><strong>Price:</strong>{{ $product->price }}</p>
            <p><strong>Stock:</strong> {{ $product->stock }}</p>

            <div class="mt-6 flex space-x-3">
                <a href="{{ route('admin.products.index') }}"
                   class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600">
                    Back
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
