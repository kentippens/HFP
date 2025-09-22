<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteAction as TableDeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->adminUser = User::factory()->create([
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
        ]);
        
        $this->actingAs($this->adminUser);
    }

    public function test_can_render_user_list_page()
    {
        User::factory(5)->create();

        $response = $this->get(UserResource::getUrl('index'));

        $response->assertSuccessful();
    }

    public function test_can_render_user_create_page()
    {
        $response = $this->get(UserResource::getUrl('create'));

        $response->assertSuccessful();
    }

    public function test_can_create_user_with_valid_data()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'SecurePassword123!',
            'password_confirmation' => 'SecurePassword123!',
        ];

        Livewire::test(UserResource\Pages\CreateUser::class)
            ->fillForm($userData)
            ->call('create')
            ->assertHasNoFormErrors();

        $user = User::where('email', 'john@example.com')->first();
        
        $this->assertNotNull($user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertTrue(Hash::check('SecurePassword123!', $user->password));
    }

    public function test_cannot_create_user_with_duplicate_email()
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $userData = [
            'name' => 'John Doe',
            'email' => 'existing@example.com',
            'password' => 'SecurePassword123!',
            'password_confirmation' => 'SecurePassword123!',
        ];

        Livewire::test(UserResource\Pages\CreateUser::class)
            ->fillForm($userData)
            ->call('create')
            ->assertHasFormErrors(['email']);
    }

    public function test_cannot_create_user_with_invalid_email()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'password' => 'SecurePassword123!',
            'password_confirmation' => 'SecurePassword123!',
        ];

        Livewire::test(UserResource\Pages\CreateUser::class)
            ->fillForm($userData)
            ->call('create')
            ->assertHasFormErrors(['email']);
    }

    public function test_cannot_create_user_with_short_password()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => '123',
            'password_confirmation' => '123',
        ];

        Livewire::test(UserResource\Pages\CreateUser::class)
            ->fillForm($userData)
            ->call('create')
            ->assertHasFormErrors(['password']);
    }

    public function test_cannot_create_user_with_mismatched_password_confirmation()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'SecurePassword123!',
            'password_confirmation' => 'DifferentPassword123!',
        ];

        Livewire::test(UserResource\Pages\CreateUser::class)
            ->fillForm($userData)
            ->call('create')
            ->assertHasFormErrors(['password_confirmation']);
    }

    public function test_cannot_create_user_without_required_fields()
    {
        Livewire::test(UserResource\Pages\CreateUser::class)
            ->fillForm([])
            ->call('create')
            ->assertHasFormErrors(['name', 'email', 'password']);
    }

    public function test_can_edit_existing_user()
    {
        $user = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
        ]);

        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        Livewire::test(UserResource\Pages\EditUser::class, ['record' => $user->id])
            ->fillForm($updatedData)
            ->call('save')
            ->assertHasNoFormErrors();

        $user->refresh();
        $this->assertEquals('Updated Name', $user->name);
        $this->assertEquals('updated@example.com', $user->email);
    }

    public function test_can_edit_user_without_changing_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('OriginalPassword'),
        ]);
        
        $originalPassword = $user->password;

        Livewire::test(UserResource\Pages\EditUser::class, ['record' => $user->id])
            ->fillForm([
                'name' => 'Updated Name',
                'email' => $user->email,
                'password' => '',
                'password_confirmation' => '',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $user->refresh();
        $this->assertEquals($originalPassword, $user->password);
    }

    public function test_can_update_user_password()
    {
        $user = User::factory()->create();

        Livewire::test(UserResource\Pages\EditUser::class, ['record' => $user->id])
            ->fillForm([
                'name' => $user->name,
                'email' => $user->email,
                'password' => 'NewSecurePassword123!',
                'password_confirmation' => 'NewSecurePassword123!',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $user->refresh();
        $this->assertTrue(Hash::check('NewSecurePassword123!', $user->password));
    }

    public function test_can_delete_user()
    {
        $user = User::factory()->create();

        Livewire::test(UserResource\Pages\EditUser::class, ['record' => $user->id])
            ->callAction(DeleteAction::class);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_can_view_user_details()
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'email_verified_at' => now(),
        ]);

        $response = $this->get(UserResource::getUrl('edit', ['record' => $user->id]));

        $response->assertSuccessful();
    }

    public function test_user_table_displays_correct_data()
    {
        $users = User::factory(3)->create();

        Livewire::test(UserResource\Pages\ListUsers::class)
            ->assertCanSeeTableRecords($users);
    }

    public function test_can_search_users_by_name()
    {
        $user1 = User::factory()->create(['name' => 'John Doe']);
        $user2 = User::factory()->create(['name' => 'Jane Smith']);

        Livewire::test(UserResource\Pages\ListUsers::class)
            ->searchTable('John')
            ->assertCanSeeTableRecords([$user1])
            ->assertCanNotSeeTableRecords([$user2]);
    }

    public function test_can_search_users_by_email()
    {
        $user1 = User::factory()->create(['email' => 'john@example.com']);
        $user2 = User::factory()->create(['email' => 'jane@example.com']);

        Livewire::test(UserResource\Pages\ListUsers::class)
            ->searchTable('john@')
            ->assertCanSeeTableRecords([$user1])
            ->assertCanNotSeeTableRecords([$user2]);
    }

    public function test_can_filter_users_by_email_verification()
    {
        $verifiedUser = User::factory()->create(['email_verified_at' => now()]);
        $unverifiedUser = User::factory()->create(['email_verified_at' => null]);

        Livewire::test(UserResource\Pages\ListUsers::class)
            ->filterTable('email_verified_at', true)
            ->assertCanSeeTableRecords([$verifiedUser])
            ->assertCanNotSeeTableRecords([$unverifiedUser]);
    }
}