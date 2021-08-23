<?php

namespace Tests\Feature;

use App\Task;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    public function testsArticlesAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'title' => 'Lorem',
            'body' => 'Ipsum',
        ];

        $this->json('POST', '/api/articles', $payload, $headers)
            ->assertStatus(200)
            ->assertJson([ 'id' => 1, 'title' => 'Lorem', 'body' => 'Ipsum' ]);
    }

    public function testsArticlesAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $article = factory(Task::class)->create([
            'title' => 'First Task',
            'body' => 'First Body',
        ]);

        $payload = [
            'title' => 'Lorem',
            'body' => 'Ipsum',
        ];

        $response = $this->json('PUT', '/api/articles/' . $article->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([ 'id' => 1, 'title' => 'Lorem', 'body' => 'Ipsum' ]);
    }

    public function testsArtilcesAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $article = factory(Task::class)->create([
            'title' => 'First Task',
            'body' => 'First Body',
        ]);

        $this->json('DELETE', '/api/articles/' . $article->id, [], $headers)
            ->assertStatus(204);
    }

    public function testArticlesAreListedCorrectly()
    {
        factory(Task::class)->create([
            'title' => 'First Task',
            'body' => 'First Body'
        ]);

        factory(Task::class)->create([
            'title' => 'Second Task',
            'body' => 'Second Body'
        ]);

        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/articles', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                [ 'title' => 'First Task', 'body' => 'First Body' ],
                [ 'title' => 'Second Task', 'body' => 'Second Body' ]
            ])
            ->assertJsonStructure([
                '*' => ['id', 'body', 'title', 'created_at', 'updated_at'],
            ]);
    }

    public function testUserCantAccessArticlesWithWrongToken()
    {
        factory(Task::class)->create();
        $user = factory(User::class)->create([ 'email' => 'user@test.com' ]);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $user->generateToken();

        $this->json('get', '/api/articles', [], $headers)->assertStatus(401);
    }

    public function testUserCantAccessArticlesWithoutToken()
    {
        factory(Task::class)->create();

        $this->json('get', '/api/articles')->assertStatus(401);
    }
}
