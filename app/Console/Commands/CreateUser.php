<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user for LAPTOP EXPERT barcode printing system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Create New User');
        $this->info('==============');

        $name = $this->ask('Enter user name');
        $email = $this->ask('Enter email address');
        
        // Check if email already exists
        if (User::where('email', $email)->exists()) {
            $this->error('User with this email already exists!');
            return 1;
        }

        $password = $this->secret('Enter password (min 8 characters)');
        $passwordConfirm = $this->secret('Confirm password');

        if ($password !== $passwordConfirm) {
            $this->error('Passwords do not match!');
            return 1;
        }

        if (strlen($password) < 8) {
            $this->error('Password must be at least 8 characters!');
            return 1;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('');
        $this->info('User created successfully!');
        $this->table(
            ['Field', 'Value'],
            [
                ['Name', $user->name],
                ['Email', $user->email],
                ['ID', $user->id],
            ]
        );

        return 0;
    }
}
