<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Product') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <a href="{{ route('admin.products.index') }}" class="px-4 py-2 dark:bg-gray-800 rounded-lg shadow bg-white">
            Manage Products
        </a>

        <div class="bg-white mt-6 dark:bg-gray-800 shadow sm:rounded-lg p-6">
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-200 font-medium">Product Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" required>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 dark:text-gray-200 font-medium">Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200">{{ old('description') }}</textarea>
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label for="price" class="block text-gray-700 dark:text-gray-200 font-medium">Price ($)</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" required>
                </div>

                <!-- Image -->
                <div class="mb-4">
                    <label for="image" class="block text-gray-700 dark:text-gray-200 font-medium">Product Image</label>
                    <input type="file" name="image" id="image"
                        class="mt-1 block w-full text-gray-700 dark:text-gray-200">
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label for="category" class="block text-gray-700 dark:text-gray-200 font-medium">Category</label>
                    <input type="text" name="category" id="category" value="{{ old('category') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" required>
                </div>

                <!-- Stock -->
                <div class="mb-4">
                    <label for="stock" class="block text-gray-700 dark:text-gray-200 font-medium">Stock</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" required>
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.products.index') }}"
                       class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow">Cancel</a>


                    <button type="submit"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow ml-3">Create Product</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
