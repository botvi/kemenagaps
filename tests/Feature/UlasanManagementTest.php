<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Ulasan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UlasanManagementTest extends TestCase
{
    use DatabaseTransactions;

    public function test_anyone_can_see_user_ulasan_page(): void
    {
        $response = $this->get(route('user.ulasan'));

        $response->assertStatus(200);
        $response->assertSee('Ulasan &amp; Testimoni', false);
    }

    public function test_guest_cannot_post_review(): void
    {
        $response = $this->post(route('user.ulasan.store'), [
            'rating' => 5,
            'ulasan' => 'Layanan yang sangat luar biasa sekali.',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_logged_in_user_can_post_review(): void
    {
        $user = User::create([
            'role' => 'user',
            'username' => 'testuserulasan',
            'name' => 'Test User Ulasan',
            'email' => 'testuserulasan@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->post(route('user.ulasan.store'), [
            'rating' => 5,
            'ulasan' => 'Layanan yang sangat luar biasa sekali.',
        ]);

        $response->assertRedirect(route('user.ulasan'));
        
        $this->assertDatabaseHas('ulasans', [
            'user_id' => $user->id,
            'rating' => 5,
            'ulasan' => 'Layanan yang sangat luar biasa sekali.',
            'published' => true,
        ]);
    }

    public function test_post_review_validation_errors(): void
    {
        $user = User::create([
            'role' => 'user',
            'username' => 'testuserulasanval',
            'name' => 'Test User Ulasan Val',
            'email' => 'testuserulasanval@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->post(route('user.ulasan.store'), [
            'rating' => 10, // Invalid
            'ulasan' => 'abc', // Too short
        ]);

        $response->assertSessionHasErrors(['rating', 'ulasan']);
    }

    public function test_superadmin_can_see_reviews_in_admin_panel(): void
    {
        $admin = User::create([
            'role' => 'superadmin',
            'username' => 'adminulasantest',
            'name' => 'Admin Ulasan Test',
            'email' => 'adminulasantest@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($admin)->get(route('ulasan.index'));

        $response->assertStatus(200);
        $response->assertSee('Kelola Ulasan Jemaah');
    }

    public function test_superadmin_can_toggle_publication_status(): void
    {
        $user = User::create([
            'role' => 'user',
            'username' => 'jemaahulasantest',
            'name' => 'Jemaah Ulasan Test',
            'email' => 'jemaahulasantest@example.com',
            'password' => bcrypt('password'),
        ]);

        $ulasan = Ulasan::create([
            'user_id' => $user->id,
            'rating' => 4,
            'ulasan' => 'Bagus sekali layanannya.',
            'published' => true,
        ]);

        $admin = User::create([
            'role' => 'superadmin',
            'username' => 'adminulasantest2',
            'name' => 'Admin Ulasan Test 2',
            'email' => 'adminulasantest2@example.com',
            'password' => bcrypt('password'),
        ]);

        // Unpublish
        $response = $this->actingAs($admin)->put(route('ulasan.update', $ulasan->id), [
            'published' => 0,
        ]);

        $response->assertRedirect(route('ulasan.index'));
        $this->assertDatabaseHas('ulasans', [
            'id' => $ulasan->id,
            'published' => false,
        ]);

        // Publish again
        $response2 = $this->actingAs($admin)->put(route('ulasan.update', $ulasan->id), [
            'published' => 1,
        ]);

        $response2->assertRedirect(route('ulasan.index'));
        $this->assertDatabaseHas('ulasans', [
            'id' => $ulasan->id,
            'published' => true,
        ]);
    }

    public function test_superadmin_can_delete_review(): void
    {
        $user = User::create([
            'role' => 'user',
            'username' => 'jemaahulasantest3',
            'name' => 'Jemaah Ulasan Test 3',
            'email' => 'jemaahulasantest3@example.com',
            'password' => bcrypt('password'),
        ]);

        $ulasan = Ulasan::create([
            'user_id' => $user->id,
            'rating' => 4,
            'ulasan' => 'Bagus sekali layanannya.',
            'published' => true,
        ]);

        $admin = User::create([
            'role' => 'superadmin',
            'username' => 'adminulasantest3',
            'name' => 'Admin Ulasan Test 3',
            'email' => 'adminulasantest3@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($admin)->delete(route('ulasan.destroy', $ulasan->id));

        $response->assertRedirect(route('ulasan.index'));
        $this->assertDatabaseMissing('ulasans', [
            'id' => $ulasan->id,
        ]);
    }
}
