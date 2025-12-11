<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PklRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_pkl_registration_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('pendaftaran.index'));

        $response->assertStatus(200);
    }

    public function test_pkl_registration_can_be_submitted(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('document.pdf', 100);

        $response = $this->actingAs($user)->post(route('pendaftaran.store'), [
            'education_level' => 'S1',
            'institution_name' => 'Test University',
            'major' => 'Computer Science',
            'nim' => '12345678',
            'start_date' => '2024-01-01',
            'end_date' => '2024-06-01',
            'file' => $file,
        ]);

        $response->assertRedirect(route('pendaftaran.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('pkl_applications', [
            'user_id' => $user->id,
            'institution_name' => 'Test University',
            'nim' => '12345678',
        ]);

        Storage::disk('public')->assertExists('pkl_files/' . $file->hashName());
    }
}
