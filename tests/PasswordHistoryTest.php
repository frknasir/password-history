<?php

namespace StarfolkSoftware\PasswordHistory\Tests;

use Illuminate\Support\Facades\Hash;
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
            'email' => 'frknasir@yahoo.com',
            'password' => Hash::make('password'),
        ]);

        $passwordHistory = PasswordHistory::first();

        $this->assertSame(
            (int) $user->id,
            (int) $passwordHistory->user_id
        );
    }

    /** @test */
    public function user_has_password_histories()
    {
        $user = SampleUser::create([
            'id' => 1,
            'name' => 'Faruk Nasir',
            'email' => 'frknasir@yahoo.com',
            'password' => Hash::make('password'),
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
    public function password_history_has_owner()
    {
        $user = SampleUser::create([
            'id' => 1,
            'name' => 'Faruk Nasir',
            'email' => 'frknasir@yahoo.com',
            'password' => Hash::make('password'),
        ]);

        $passwordHistory = PasswordHistory::first();

        $this->assertSame((int) collect($passwordHistory->owner)['id'], (int) $user->id);
    }

    /** @test */
    public function user_can_not_change_password_to_a_recently_used_password()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $this->expectErrorMessage('The given data was invalid.');

        $user = SampleUser::create([
            'id' => 1,
            'name' => 'Faruk Nasir',
            'email' => 'frknasir@yahoo.com',
            'password' => Hash::make('password'),
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
            'email' => 'frknasir@yahoo.com',
            'password' => Hash::make('password1'),
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
}
