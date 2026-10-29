<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_posts_can_be_created_listed_viewed_updated_and_deleted(): void
    {
        $this->get(route('posts.create'))->assertOk();

        $this->post(route('posts.store'), [
            'title' => 'First post',
            'body' => 'Post body',
        ])->assertRedirect(route('posts.index'));

        $post = Post::firstOrFail();

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'First post',
            'body' => 'Post body',
        ]);

        $this->get(route('posts.index'))
            ->assertOk()
            ->assertSeeText('First post');

        $this->get(route('posts.show', $post))
            ->assertOk()
            ->assertSeeText('Post body');

        $this->get(route('posts.edit', $post))->assertOk();

        $this->put(route('posts.update', $post), [
            'title' => 'Updated post',
            'body' => 'Updated body',
        ])->assertRedirect(route('posts.index'));

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated post',
            'body' => 'Updated body',
        ]);

        $this->delete(route('posts.destroy', $post))
            ->assertRedirect(route('posts.index'));

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_post_fields_are_required(): void
    {
        $this->from(route('posts.create'))
            ->post(route('posts.store'), [])
            ->assertRedirect(route('posts.create'))
            ->assertSessionHasErrors(['title', 'body']);
    }
}
