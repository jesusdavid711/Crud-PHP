<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A user can see their own products.
     */
    public function test_user_can_see_their_own_products(): void
    {
        $user = User::factory()->create();
        $producto = Producto::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('productos.index'));

        $response->assertStatus(200);
        $response->assertSee($producto->nombre);
    }

    /**
     * A user cannot see other users' products.
     */
    public function test_user_cannot_see_other_users_products(): void
    {
        $user1 = User::factory()->create(['is_admin' => false]);
        $user2 = User::factory()->create(['is_admin' => false]);
        $producto = Producto::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)->get(route('productos.index'));

        $response->assertStatus(200);
        $response->assertDontSee($producto->nombre);
    }

    /**
     * An admin can see all products.
     */
    public function test_admin_can_see_all_products(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create(['is_admin' => false]);
        $producto = Producto::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($admin)->get(route('productos.index'));

        $response->assertStatus(200);
        $response->assertSee($producto->nombre);
        $response->assertSee($user->name);
    }

    /**
     * A product can be created with a category.
     */
    public function test_product_can_be_created_with_category(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $image = UploadedFile::fake()->image('product.jpg');

        $data = [
            'category_id' => $category->id,
            'nombre' => 'Test Product',
            'descripcion' => 'Description test',
            'precio' => 99.99,
            'stock' => 10,
            'imagen' => $image,
        ];

        $response = $this->actingAs($user)->post(route('productos.store'), $data);

        $response->assertRedirect(route('productos.index'));
        $this->assertDatabaseHas('productos', [
            'nombre' => 'Test Product',
            'category_id' => $category->id,
            'user_id' => $user->id
        ]);

        $producto = Producto::where('nombre', 'Test Product')->first();
        $this->assertNotNull($producto->imagen);
        Storage::disk('public')->assertExists($producto->imagen);
    }

    /**
     * A product requires a valid category.
     */
    public function test_product_requires_valid_category(): void
    {
        $user = User::factory()->create();
        $data = [
            'category_id' => 999, // Non-existent
            'nombre' => 'Invalid Product',
            'precio' => 10,
            'stock' => 5,
        ];

        $response = $this->actingAs($user)->post(route('productos.store'), $data);

        $response->assertSessionHasErrors(['category_id']);
    }
}
