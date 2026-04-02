<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
class ExampleTest extends TestCase
{
  use RefreshDatabase;


  public function test_the_application_returns_a_successful_response(): void
  {
    Product::factory()->create();
    $response = $this->get('/');

    $response->assertStatus(200);
  }
}
