<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('admin is redirected to dashboard after successful login', function (): void {
    $admin = User::factory()->withoutTwoFactor()->create([
        'email' => 'admin@mail.com',
        'password' => 'password',
    ]);

    $response = $this->post(route('login.store'), [
        'email' => $admin->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('dashboard', absolute: false));
    $this->assertAuthenticatedAs($admin);
});

test('guest is redirected to login when accessing dashboard', function (): void {
    $response = $this->get(route('dashboard'));

    $response->assertRedirect(route('login'));
});

test('authenticated admin can view dashboard page', function (): void {
    $admin = User::factory()->withoutTwoFactor()->create();

    $response = $this->actingAs($admin)->get(route('dashboard'));

    $response->assertOk();
    $response->assertInertia(fn (Assert $page): Assert => $page->component('Dashboard'));
});
