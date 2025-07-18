<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ApplicationTest extends TestCase
{
    /**
     * Test the home page loads successfully.
     */
    public function test_home_page_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test the products page loads successfully.
     */
    public function test_products_page_loads(): void
    {
        $response = $this->get('/products');
        $response->assertStatus(200);
    }

    /**
     * Test the categories page loads successfully.
     */
    public function test_categories_page_loads(): void
    {
        $response = $this->get('/categories');
        $response->assertStatus(200);
    }

    /**
     * Test the cart page loads successfully.
     */
    public function test_cart_page_loads(): void
    {
        $response = $this->get('/cart');
        $response->assertStatus(200);
    }

    /**
     * Test the search functionality.
     */
    public function test_search_functionality(): void
    {
        $response = $this->get('/search?q=test');
        $response->assertStatus(200);
    }

    /**
     * Test API search suggestions.
     */
    public function test_api_search_suggestions(): void
    {
        $response = $this->get('/api/search-suggestions?q=test');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'suggestions'
        ]);
    }

    /**
     * Test static pages load successfully.
     */
    public function test_static_pages_load(): void
    {
        $pages = ['about', 'contact', 'privacy', 'terms', 'returns', 'faq', 'offers'];
        
        foreach ($pages as $page) {
            $response = $this->get("/$page");
            $response->assertStatus(200);
        }
    }

    /**
     * Test that the cart count API works.
     */
    public function test_cart_count_api(): void
    {
        $response = $this->get('/cart/count');
        $response->assertStatus(200);
    }
}
