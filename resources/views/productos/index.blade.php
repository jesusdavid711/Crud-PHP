@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Productos</h1>
            <p class="mt-1 text-sm text-gray-600">Gestiona tu inventario de productos</p>
        </div>
        <a href="{{ route('productos.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nuevo Producto
        </a>
    </div>
</div>

@if($productos->isEmpty())
<div class="bg-white rounded-lg shadow-md p-12 text-center">
    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
    </svg>
    <h3 class="mt-4 text-lg font-medium text-gray-900">No hay productos</h3>
    <p class="mt-2 text-sm text-gray-500">Comienza creando tu primer producto.</p>
    <div class="mt-6">
        <a href="{{ route('productos.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Crear Producto
        </a>
    </div>
</div>
@else
<!-- Desktop Table View -->
<div class="hidden md:block bg-white rounded-lg shadow-md overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($productos as $producto)
            <tr class="hover:bg-gray-50 transition duration-150">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $producto->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ $producto->nombre }}</div>
                    @if($producto->descripcion)
                    <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($producto->descripcion, 50) }}</div>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">${{ number_format($producto->precio, 2) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $producto->stock > 10 ? 'bg-green-100 text-green-800' : ($producto->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ $producto->stock }} unidades
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('productos.show', $producto->id) }}" class="text-blue-600 hover:text-blue-900 mr-3 transition">Ver</a>
                    <a href="{{ route('productos.edit', $producto->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3 transition">Editar</a>
                    <form action="{{ route('productos.remove', $producto->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 transition">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Mobile Card View -->
<div class="md:hidden space-y-4">
    @foreach($productos as $producto)
    <div class="bg-white rounded-lg shadow-md p-4">
        <div class="flex justify-between items-start mb-3">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ $producto->nombre }}</h3>
                <p class="text-sm text-gray-600">ID: {{ $producto->id }}</p>
            </div>
            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $producto->stock > 10 ? 'bg-green-100 text-green-800' : ($producto->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                {{ $producto->stock }} unidades
            </span>
        </div>

        @if($producto->descripcion)
        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($producto->descripcion, 80) }}</p>
        @endif

        <div class="mb-4">
            <span class="text-xl font-bold text-indigo-600">${{ number_format($producto->precio, 2) }}</span>
        </div>

        <div class="flex space-x-2">
            <a href="{{ route('productos.show', $producto->id) }}" class="flex-1 text-center px-3 py-2 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-200 transition">Ver</a>
            <a href="{{ route('productos.edit', $producto->id) }}" class="flex-1 text-center px-3 py-2 bg-indigo-100 text-indigo-700 rounded-lg text-sm font-medium hover:bg-indigo-200 transition">Editar</a>
            <form action="{{ route('productos.remove', $producto->id) }}" method="POST" class="flex-1" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full px-3 py-2 bg-red-100 text-red-700 rounded-lg text-sm font-medium hover:bg-red-200 transition">Eliminar</button>
            </form>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $productos->links() }}
</div>
@endif
@endsection