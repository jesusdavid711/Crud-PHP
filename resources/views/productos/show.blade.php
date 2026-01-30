<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalle del Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6 flex justify-end">
                <a href="{{ route('productos.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver
                </a>
            </div>

            <!-- Product Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="md:flex">
                    <!-- Image Section -->
                    <div class="md:w-1/3 bg-gray-100 dark:bg-gray-700 flex items-center justify-center p-8">
                        @if($producto->imagen)
                        <img src="{{ $producto->imagen }}" alt="{{ $producto->nombre }}" class="max-w-full h-auto rounded-lg shadow-md">
                        @else
                        <div class="text-center">
                            <svg class="mx-auto h-32 w-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Sin imagen</p>
                        </div>
                        @endif
                    </div>

                    <!-- Info Section -->
                    <div class="md:w-2/3 p-8">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $producto->nombre }}</h2>
                            <div class="flex items-center space-x-4">
                                <span class="text-3xl font-bold text-indigo-600">${{ number_format($producto->precio, 2) }}</span>
                                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $producto->stock > 10 ? 'bg-green-100 text-green-800' : ($producto->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $producto->stock }} en stock
                                </span>
                            </div>
                        </div>

                        <div class="space-y-4 mb-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">ID</h3>
                                <p class="text-gray-900 dark:text-white">{{ $producto->id }}</p>
                            </div>

                            @if($producto->descripcion)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Descripción</h3>
                                <p class="text-gray-900 dark:text-white">{{ $producto->descripcion }}</p>
                            </div>
                            @endif

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Precio Unitario</h3>
                                    <p class="text-gray-900 dark:text-white font-semibold">${{ number_format($producto->precio, 2) }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Cantidad en Stock</h3>
                                    <p class="text-gray-900 dark:text-white font-semibold">{{ $producto->stock }} unidades</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Creado</h3>
                                    <p class="text-gray-900 dark:text-white text-sm">{{ $producto->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Última Actualización</h3>
                                    <p class="text-gray-900 dark:text-white text-sm">{{ $producto->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex space-x-3 pt-4 border-t border-gray-200 dark:border-gray-600">
                            <a href="{{ route('productos.edit', $producto->id) }}" class="flex-1 text-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition">
                                Editar Producto
                            </a>
                            <form action="{{ route('productos.remove', $producto->id) }}" method="POST" class="flex-1" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                                    Eliminar Producto
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>