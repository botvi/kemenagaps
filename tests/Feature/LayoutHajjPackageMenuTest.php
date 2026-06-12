<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\PaketHaji;
use App\Models\CalonJemaah;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LayoutHajjPackageMenuTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_user_can_see_hajj_package_menu(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee(route('user.paket'), false);
    }

    public function test_regular_logged_in_user_without_pilgrim_registration_can_see_hajj_package_menu(): void
    {
        $id = 999999;
        while (User::where('id', $id)->exists() || CalonJemaah::where('user_id', $id)->exists()) {
            $id = rand(100000, 999000);
        }

        $user = new User();
        $user->id = $id;
        $user->role = 'user';
        $user->username = 'testregular_' . $id;
        $user->name = 'Test Regular User';
        $user->password = bcrypt('password');
        $user->save();

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee(route('user.paket'), false);
    }

    public function test_logged_in_user_registered_as_pilgrim_does_not_see_hajj_package_menu(): void
    {
        // 1. Create a user
        $id = 888888;
        while (User::where('id', $id)->exists() || CalonJemaah::where('user_id', $id)->exists()) {
            $id = rand(100000, 999000);
        }

        $user = new User();
        $user->id = $id;
        $user->role = 'user';
        $user->username = 'testpilgrim_' . $id;
        $user->name = 'Test Pilgrim User';
        $user->password = bcrypt('password');
        $user->save();

        // 2. Create Paket Haji
        $paket = PaketHaji::create([
            'nama_paket' => 'Paket Test Haji',
            'kategori' => 'Haji Plus',
            'harga' => 150000000,
            'durasi' => '30 hari',
            'published' => true,
        ]);

        // 3. Create Calon Jemaah linked directly to Paket Haji
        CalonJemaah::create([
            'user_id' => $user->id,
            'paket_haji_id' => $paket->id,
            'tahun_pendaftaran' => now()->year,
            'kodelogin' => 'TEST_PILGRIM_CODE_2',
            'status_pendaftaran' => 'dikonfirmasi',
        ]);

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertStatus(200);
        $response->assertDontSee(route('user.paket'), false);
    }
}
