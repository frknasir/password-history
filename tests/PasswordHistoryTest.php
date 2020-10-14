<?php

namespace StarfolkSoftware\PasswordHistory\Tests;

<<<<<<< HEAD
use StarfolkSoftware\PasswordHistory\Tests\Models\{SampleUser, AdminUser};
=======
use Illuminate\Support\Facades\Hash;
>>>>>>> 91a0cacf4dd52bfad827ef7827d63b2e6c52569d
use StarfolkSoftware\PasswordHistory\PasswordHistory;
use StarfolkSoftware\PasswordHistory\Rules\NotInRecentPasswordHistory;
use StarfolkSoftware\PasswordHistory\Tests\Models\SampleUser;

class PasswordHistoryTest extends TestCase
{
    /** @test */
    public function password_history_can_be_saved()
    {
        $user = SampleUser::create([
            'id' => 1,
            'name' => 'Faruk Nasir',
            'email' => 'frknasir1@example.com',
            'password' => Hash::make('password')
        ]);

        auth()->login($user);

        $user->password = Hash::make('password1');
        $user->save();

        $passwordHistory = PasswordHistory::find(2);

        $this->assertSame(
            (int) $user->id,
            (int) $passwordHistory->user_id
        );

        $user2 = SampleUser::create([
            'id' => 1,
            'name' => 'Nasir Faruk',
            'email' => 'frknasir@example.com',
            'password' => Hash::make('password')
        ]);

        auth()->login($user2);

        $user->password = Hash::make('password1');
        $user->save();

        $passwordHistory2 = PasswordHistory::find(4);

        $this->assertSame(
            (int) $user2->id,
            (int) $passwordHistory2->user_id
        );
    }

    /** @test */
    public function user_has_password_histories()
    {
        $user = SampleUser::create([
            'id' => 1,
            'name' => 'Faruk Nasir',
<<<<<<< HEAD
            'email' => 'frknasir@example.com',
            'password' => Hash::make('password')
=======
            'email' => 'frknasir@yahoo.com',
            'password' => Hash::make('password'),
>>>>>>> 91a0cacf4dd52bfad827ef7827d63b2e6c52569d
        ]);

        $this->assertSame(
            $user->previousPasswords()->count(),
            1
        );

        $user = SampleUser::find(1);
        $user->password = Hash::make('password1');
        $user->save();

        $this->assertSame(
            $user->previousPasswords()->count(),
            2
        );
    }

    /** @test */
<<<<<<< HEAD
    public function password_history_has_historian() {
        $user = SampleUser::create([
            'id' => 1,
            'name' => 'Faruk Nasir',
            'email' => 'frknasir@example.com',
            'password' => Hash::make('password')
        ]);

        auth()->login($user);

        $user->password = Hash::make('anotherOne');
        $user->save();

        $passwordHistory = PasswordHistory::find(2);

        $this->assertSame(PasswordHistory::all()->count(), 2);
        $this->assertSame($passwordHistory->historian->id, 1);
    }

    /** @test */
    public function password_history_has_model() {
        $user = SampleUser::create([
            'id' => 1,
            'name' => 'Faruk Nasir',
            'email' => 'frknasir@example.com',
            'password' => Hash::make('password')
=======
    public function password_history_has_owner()
    {
        $user = SampleUser::create([
            'id' => 1,
            'name' => 'Faruk Nasir',
            'email' => 'frknasir@yahoo.com',
            'password' => Hash::make('password'),
>>>>>>> 91a0cacf4dd52bfad827ef7827d63b2e6c52569d
        ]);

        $passwordHistory = PasswordHistory::find(1);
        $model = $passwordHistory->passwordhistorable;

        $this->assertSame($model->id, 1);
    }

    /** @test */
    public function user_can_not_change_password_to_a_recently_used_password()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $this->expectErrorMessage('The given data was invalid.');

        $user = SampleUser::create([
            'id' => 1,
            'name' => 'Faruk Nasir',
<<<<<<< HEAD
            'email' => 'frknasir@example.com',
            'password' => Hash::make('password')
=======
            'email' => 'frknasir@yahoo.com',
            'password' => Hash::make('password'),
>>>>>>> 91a0cacf4dd52bfad827ef7827d63b2e6c52569d
        ]);

        $user = SampleUser::find(1);
        $user->password = 'password';

        try {
            validator(collect($user)->toArray(), [
                'password' => NotInRecentPasswordHistory::ofUser($user),
            ])->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        }
    }

    /** @test */
    public function user_can_change_password_to_a_previously_used_password_that_escapes_the_check_length()
    {
        $user = SampleUser::create([
            'id' => 1,
            'name' => 'Faruk Nasir',
<<<<<<< HEAD
            'email' => 'frknasir@example.com',
            'password' => Hash::make('password1')
=======
            'email' => 'frknasir@yahoo.com',
            'password' => Hash::make('password1'),
>>>>>>> 91a0cacf4dd52bfad827ef7827d63b2e6c52569d
        ]);

        $user = SampleUser::find(1);
        $user->password = Hash::make('password2');
        $user->save();

        $user = SampleUser::find(1);
        $user->password = Hash::make('password3');
        $user->save();

        $user = SampleUser::find(1);
        $user->password = Hash::make('password4');
        $user->save();

        $user = SampleUser::find(1);
        $user->password = Hash::make('password5');
        $user->save();

        $user = SampleUser::find(1);
        $user->password = Hash::make('password6');
        $user->save();

        $user = SampleUser::find(1);
        $user->password = 'password1';
        $user->refresh();

        try {
            validator(collect($user)->toArray(), [
                'password' => NotInRecentPasswordHistory::ofUser($user),
            ])->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        }

        $user->password = Hash::make('password1');
        $user->save();

        $this->assertSame(PasswordHistory::all()->count(), 7);
    }

    /** @test */
    public function two_models_with_password_history()
    {
        $user = SampleUser::create([
            'id' => 1,
            'name' => 'Faruk Nasir',
            'email' => 'frknasir1@example.com',
            'password' => Hash::make('password')
        ]);

        $user2 = AdminUser::create([
            'id' => 2,
            'name' => 'Nasir Faruk',
            'email' => 'frknasir@example.com',
            'password' => Hash::make('password')
        ]);

        $this->assertSame(
            PasswordHistory::all()->count(),
            2
        );

        $this->assertSame(
            $user->previousPasswords()->count(),
            1
        );

        $this->assertSame(
            $user2->previousPasswords()->count(),
            1
        );
    }
}
