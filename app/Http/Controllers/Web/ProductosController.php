<?php


namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            // Admin sees all products with owner information
            $productos = Producto::with('user')->latest()->paginate(10);
        } else {
            // Regular user sees only their own products
            $productos = $user->productos()->latest()->paginate(10);
        }

        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductoRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        Producto::create($data);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $producto = $this->getProductoWithAuthorization($id);

        if (!$producto) {
            abort(Response::HTTP_FORBIDDEN, 'You do not have permission to view this product.');
        }

        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $producto = $this->getProductoWithAuthorization($id);

        if (!$producto) {
            abort(Response::HTTP_FORBIDDEN, 'You do not have permission to edit this product.');
        }

        return view('productos.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductoRequest $request, $id)
    {
        $producto = $this->getProductoWithAuthorization($id);

        if (!$producto) {
            abort(Response::HTTP_FORBIDDEN, 'You do not have permission to update this product.');
        }

        $producto->update($request->validated());

        return redirect()
            ->route('productos.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function remove($id)
    {
        $producto = $this->getProductoWithAuthorization($id);

        if (!$producto) {
            abort(Response::HTTP_FORBIDDEN, 'You do not have permission to delete this product.');
        }

        $producto->delete();

        return redirect()
            ->route('productos.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Get product if user has authorization.
     * Admin can access any product, regular user only their own.
     */
    private function getProductoWithAuthorization($id): ?Producto
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $producto = Producto::find($id);

        if (!$producto) {
            abort(Response::HTTP_NOT_FOUND, 'Product not found.');
        }

        // Admin can access any product
        if ($user->isAdmin()) {
            return $producto;
        }

        // Regular user can only access their own products
        if ($producto->user_id === $user->id) {
            return $producto;
        }

        return null;
    }
}
