<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\PertanyaanUmum;
use App\Models\PertanyaanBelumTerjawab;
use Tests\TestCase;

class ChatbotUnansweredTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Clean up beforehand just in case
        PertanyaanBelumTerjawab::where('pertanyaan', 'Test Pertanyaan Misterius')->delete();
        PertanyaanUmum::where('pertanyaan', 'Test Pertanyaan Misterius')->delete();
    }

    protected function tearDown(): void
    {
        // Clean up
        PertanyaanBelumTerjawab::where('pertanyaan', 'Test Pertanyaan Misterius')->delete();
        PertanyaanUmum::where('pertanyaan', 'Test Pertanyaan Misterius')->delete();
        parent::tearDown();
    }

    public function test_chatbot_unanswered_questions_saved_correctly(): void
    {
        // 1. Post unknown query to /api/chat
        $response = $this->postJson('/api/chat', [
            'message' => 'Test Pertanyaan Misterius'
        ]);

        $response->assertStatus(200);
        
        // Assert stored in DB
        $this->assertDatabaseHas('pertanyaan_belum_terjawabs', [
            'pertanyaan' => 'Test Pertanyaan Misterius',
            'jumlah_ditanyakan' => 1
        ]);

        // 2. Post same query again to verify increment
        $response2 = $this->postJson('/api/chat', [
            'message' => 'Test Pertanyaan Misterius'
        ]);
        $response2->assertStatus(200);

        $this->assertDatabaseHas('pertanyaan_belum_terjawabs', [
            'pertanyaan' => 'Test Pertanyaan Misterius',
            'jumlah_ditanyakan' => 2
        ]);
    }

    public function test_superadmin_can_answer_unanswered_question(): void
    {
        // 1. Create unanswered question
        $unanswered = PertanyaanBelumTerjawab::create([
            'pertanyaan' => 'Test Pertanyaan Misterius',
            'jumlah_ditanyakan' => 5
        ]);

        // 2. Create superadmin user for authentication
        $admin = User::create([
            'role' => 'superadmin',
            'username' => 'testsuperadmin',
            'name' => 'Test Superadmin',
            'email' => 'testsuperadmin@test.com',
            'password' => bcrypt('password')
        ]);

        try {
            // 3. Put answer as superadmin
            $response = $this->actingAs($admin)
                ->put(route('pertanyaan-belum-terjawab.update', $unanswered->id), [
                    'jawaban' => 'Ini jawaban misterius.'
                ]);

            $response->assertRedirect(route('pertanyaan.index'));

            // Assert unanswered is deleted
            $this->assertDatabaseMissing('pertanyaan_belum_terjawabs', [
                'id' => $unanswered->id
            ]);

            // Assert FAQ is created
            $this->assertDatabaseHas('pertanyaan_umums', [
                'pertanyaan' => 'Test Pertanyaan Misterius',
                'jawaban' => 'Ini jawaban misterius.',
                'published' => true
            ]);
        } finally {
            // Clean up the created test user
            $admin->delete();
        }
    }

    public function test_superadmin_can_ignore_unanswered_question(): void
    {
        $unanswered = PertanyaanBelumTerjawab::create([
            'pertanyaan' => 'Test Pertanyaan Misterius',
            'jumlah_ditanyakan' => 5
        ]);

        $admin = User::create([
            'role' => 'superadmin',
            'username' => 'testsuperadmin',
            'name' => 'Test Superadmin',
            'email' => 'testsuperadmin@test.com',
            'password' => bcrypt('password')
        ]);

        try {
            $response = $this->actingAs($admin)
                ->delete(route('pertanyaan-belum-terjawab.destroy', $unanswered->id));

            $response->assertRedirect(route('pertanyaan.index'));

            $this->assertDatabaseMissing('pertanyaan_belum_terjawabs', [
                'id' => $unanswered->id
            ]);
        } finally {
            $admin->delete();
        }
    }

    public function test_superadmin_can_edit_faq(): void
    {
        $faq = PertanyaanUmum::create([
            'pertanyaan' => 'Test Pertanyaan Misterius',
            'jawaban' => 'Jawaban Awal',
            'published' => true
        ]);

        $admin = User::create([
            'role' => 'superadmin',
            'username' => 'testsuperadmin',
            'name' => 'Test Superadmin',
            'email' => 'testsuperadmin@test.com',
            'password' => bcrypt('password')
        ]);

        try {
            // Test GET edit page
            $responseEdit = $this->actingAs($admin)
                ->get(route('pertanyaan.edit', $faq->id));
            
            $responseEdit->assertStatus(200);

            // Test PUT update
            $responseUpdate = $this->actingAs($admin)
                ->put(route('pertanyaan.update', $faq->id), [
                    'pertanyaan' => 'Test Pertanyaan Misterius',
                    'jawaban' => 'Jawaban Baru',
                    'published' => 'on'
                ]);

            $responseUpdate->assertRedirect(route('pertanyaan.index'));

            $this->assertDatabaseHas('pertanyaan_umums', [
                'id' => $faq->id,
                'jawaban' => 'Jawaban Baru'
            ]);
        } finally {
            $admin->delete();
        }
    }

    public function test_superadmin_can_delete_faq(): void
    {
        $faq = PertanyaanUmum::create([
            'pertanyaan' => 'Test Pertanyaan Misterius',
            'jawaban' => 'Jawaban Awal',
            'published' => true
        ]);

        $admin = User::create([
            'role' => 'superadmin',
            'username' => 'testsuperadmin',
            'name' => 'Test Superadmin',
            'email' => 'testsuperadmin@test.com',
            'password' => bcrypt('password')
        ]);

        try {
            $response = $this->actingAs($admin)
                ->delete(route('pertanyaan.destroy', $faq->id));

            $response->assertRedirect(route('pertanyaan.index'));

            $this->assertDatabaseMissing('pertanyaan_umums', [
                'id' => $faq->id
            ]);
        } finally {
            $admin->delete();
        }
    }
}
