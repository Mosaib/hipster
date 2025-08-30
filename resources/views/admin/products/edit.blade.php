<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <a href="{{ route('admin.products.index') }}"
           class="px-4 py-2 dark:bg-gray-800 rounded-lg shadow bg-white">
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

            <form action="{{ route('admin.products.update', $product->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

               <div>
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded p-2">
                </div>

                <div class="mt-4">
                    <label>Description</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="mt-4">
                    <label>Price</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full border rounded p-2">
                </div>

                <div class="mt-4">
                    <label>Image</label>
                    <input type="file" name="image" class="w-full border rounded p-2">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" class="w-20 h-20 mt-2 object-cover">
                    @endif
                </div>

                <div class="mt-4">
                    <label>Category</label>
                    <input type="text" name="category" value="{{ old('category', $product->category) }}" class="w-full border rounded p-2">
                </div>

                <div class="mt-4">
                    <label>Stock</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full border rounded p-2">
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.products.index') }}"
                       class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow ml-3">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
