<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <form action="{{ route('productos.update', $producto->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nombre -->
                    <div class="mb-6">
                        <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nombre del Producto <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            name="nombre"
                            id="nombre"
                            value="{{ old('nombre', $producto->nombre) }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('nombre') border-red-500 @enderror"
                            placeholder="Ej: Laptop Dell XPS 13"
                            required>
                        @error('nombre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descripción -->
                    <div class="mb-6">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Descripción
                        </label>
                        <textarea name="descripcion"
                            id="descripcion"
                            rows="4"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('descripcion') border-red-500 @enderror"
                            placeholder="Descripción detallada del producto...">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        @error('descripcion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Precio -->
                        <div>
                            <label for="precio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Precio <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500 dark:text-gray-400">$</span>
                                <input type="number"
                                    name="precio"
                                    id="precio"
                                    value="{{ old('precio', $producto->precio) }}"
                                    step="0.01"
                                    min="0"
                                    class="w-full pl-8 pr-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('precio') border-red-500 @enderror"
                                    placeholder="0.00"
                                    required>
                            </div>
                            @error('precio')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock -->
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Stock <span class="text-red-500">*</span>
                            </label>
                            <input type="number"
                                name="stock"
                                id="stock"
                                value="{{ old('stock', $producto->stock) }}"
                                min="0"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('stock') border-red-500 @enderror"
                                placeholder="0"
                                required>
                            @error('stock')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Imagen -->
                    <div class="mb-6">
                        <label for="imagen" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            URL de Imagen
                        </label>
                        <input type="url"
                            name="imagen"
                            id="imagen"
                            value="{{ old('imagen', $producto->imagen) }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('imagen') border-red-500 @enderror"
                            placeholder="https://ejemplo.com/imagen.jpg">
                        @error('imagen')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-600">
                        <a href="{{ route('productos.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition">
                            Cancelar
                        </a>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out">
                            Actualizar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>