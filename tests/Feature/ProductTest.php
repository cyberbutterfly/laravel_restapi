Product<?php

namespace Tests\Feature;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function testsProductsAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'name' => 'Lorem',
            'description' => 'Ipsum',
            'price' => '100'
        ];

        $this->json('POST', '/api/products', $payload, $headers)
            ->assertStatus(200)
            ->assertJson([ 'id' => 1, 'name' => 'Lorem', 'description' => 'Ipsum', 'price' => '100' ]);
    }

    public function testsProductsAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $product = factory(Product::class)->create([
            'name' => 'First Produt',
            'description' => 'First Description',
            'price' => 'First Price'
        ]);

        $payload = [
            'name' => 'Lorem',
            'description' => 'Ipsum',
            'price' => 'Dolar'
        ];

        $response = $this->json('PUT', '/api/products/' . $product->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([ 'id' => 1, 'title' => 'Lorem', 'body' => 'Ipsum' ]);
    }

    public function testsProductsAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $product = factory(Product::class)->create([
          'name' => 'First Produt',
          'description' => 'First Description',
          'price' => 'First Price'
        ]);

        $this->json('DELETE', '/api/products/' . $product->id, [], $headers)
            ->assertStatus(204);
    }

    public function testProductsAreListedCorrectly()
    {
        factory(Product::class)->create([
            'name' => 'First Product',
            'description' => 'First Description',
            'price' => '100'
        ]);

        factory(Product::class)->create([
          'name' => 'Second Product',
          'description' => 'Second Description',
          'price' => '150'
        ]);

        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/products', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                [ 'name' => 'First Product', 'description' => 'First Description', 'price' => '100' ],
                [ 'name' => 'Second Product', 'description' => 'Second Description', 'price' => '150' ]
            ])
            ->assertJsonStructure([
                '*' => ['id', 'name', 'description', 'price', 'created_at', 'updated_at'],
            ]);
    }

    public function testUserCantAccessProductsWithWrongToken()
    {
        factory(Product::class)->create();
        $user = factory(User::class)->create([ 'email' => 'user@test.com' ]);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $user->generateToken();

        $this->json('get', '/api/products', [], $headers)->assertStatus(401);
    }

    public function testUserCantAccessProductsWithoutToken()
    {
        factory(Product::class)->create();

        $this->json('get', '/api/products')->assertStatus(401);
    }
}
