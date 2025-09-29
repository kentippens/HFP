<?php

namespace App\Filament\Pages\Auth;

use App\Rules\SecurePassword;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-user';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Account';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }
    protected string $view = 'filament.pages.auth.edit-profile';

    protected static ?string $slug = 'edit-profile';

    protected static ?string $title = 'Edit Profile';

    public ?array $profileData = [];
    public ?array $passwordData = [];

    public function mount(): void
    {
        $this->profileData = [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ];
    }

    public function profileForm(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Profile Information')
                    ->description('Update your account profile information.')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ]),
            ])
            ->statePath('profileData');
    }

    public function passwordForm(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Update Password')
                    ->description('Ensure your account is using a strong password to stay secure.')
                    ->schema([
                        TextInput::make('current_password')
                            ->password()
                            ->required()
                            ->currentPassword()
                            ->revealable(),
                        TextInput::make('password')
                            ->password()
                            ->required()
                            ->revealable()
                            ->rule(new SecurePassword(
                                auth()->user()->name,
                                auth()->user()->email
                            ))
                            ->different('current_password')
                            ->validationAttribute('new password')
                            ->live()
                            ->afterStateUpdated(function ($state, $component) {
                                $this->validatePasswordStrength($state, $component);
                            }),
                        TextInput::make('password_confirmation')
                            ->password()
                            ->required()
                            ->same('password')
                            ->revealable(),
                    ])
                    ->columns(1),
            ])
            ->statePath('passwordData');
    }

    protected function validatePasswordStrength($state, $component): void
    {
        if (empty($state)) {
            return;
        }

        $rule = new SecurePassword(auth()->user()->name, auth()->user()->email);
        
        if (!$rule->passes('password', $state)) {
            $component->addError('password', $rule->message());
        } else {
            $score = $rule->getStrengthScore($state);
            
            if ($score >= 80) {
                $component->hint('Strong password!')->hintColor('success');
            } elseif ($score >= 60) {
                $component->hint('Good password strength.')->hintColor('warning');
            } else {
                $component->hint('Consider using a stronger password.')->hintColor('danger');
            }
        }
    }

    public function updateProfile(): void
    {
        $data = $this->profileForm->getState();

        auth()->user()->update($data);

        Notification::make()
            ->success()
            ->title('Profile updated')
            ->body('Your profile information has been updated successfully.')
            ->send();
    }

    public function updatePassword(): void
    {
        $data = $this->passwordForm->getState();

        // Check if password is in history
        if (auth()->user()->isPasswordInHistory($data['password'])) {
            throw ValidationException::withMessages([
                'passwordData.password' => 'You cannot reuse a recent password. Please choose a different password.',
            ]);
        }

        // Update password with history tracking
        $updated = auth()->user()->updatePassword($data['password']);

        if (!$updated) {
            throw ValidationException::withMessages([
                'passwordData.password' => 'Failed to update password. Please try a different password.',
            ]);
        }

        $this->passwordData = [];

        Notification::make()
            ->success()
            ->title('Password updated')
            ->body('Your password has been updated successfully.')
            ->send();

        // Force re-authentication with new password
        auth()->logout();
        
        redirect()->route('filament.admin.auth.login')->with('status', 'Password updated. Please login with your new password.');
    }

    protected function getForms(): array
    {
        return [
            'profileForm',
            'passwordForm',
        ];
    }
}