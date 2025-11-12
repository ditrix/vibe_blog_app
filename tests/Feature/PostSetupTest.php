<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

uses(RefreshDatabase::class);

it('creates posts table with expected columns', function (): void {
    expect(Schema::hasColumns('posts', [
        'id',
        'title',
        'slug',
        'intro',
        'body',
        'cover_path',
        'status',
        'published_at',
        'created_at',
        'updated_at',
    ]))->toBeTrue();
});

it('seeds admin user and demo posts', function (): void {
    $this->seed();

    $admin = User::query()->where('email', 'admin@mail.com')->first();

    expect($admin)->not->toBeNull()
        ->and($admin->name)->toBe('Администратор');

    expect(Post::query()->count())->toBe(5)
        ->and(Post::query()->where('status', Post::STATUS_PUBLISHED)->count())->toBeGreaterThanOrEqual(3)
        ->and(Post::query()->where('cover_path', null)->exists())->toBeTrue()
        ->and(Post::query()->distinct('slug')->count())->toBe(Post::query()->count());
});
