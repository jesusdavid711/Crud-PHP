<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A category can have many products.
     */
    public function test_category_has_many_products(): void
    {
        $category = Category::factory()->create();
        $product = Producto::factory()->create(['category_id' => $category->id]);

        $this->assertTrue($category->productos->contains($product));
        $this->assertEquals(1, $category->productos->count());
    }

    /**
     * A category must have a unique name.
     */
    public function test_category_must_have_unique_name(): void
    {
        Category::factory()->create(['nombre' => 'Test Category']);

        $this->expectException(\Illuminate\Database\QueryException::class);
        Category::factory()->create(['nombre' => 'Test Category']);
    }
}
