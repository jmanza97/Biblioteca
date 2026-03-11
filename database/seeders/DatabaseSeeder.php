<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

use function Symfony\Component\String\b;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BookSeeder::class,
            RoleAndPermissionsSeeder::class,
        ]);

        // Create a default user for testing
        $defaultUser = User::firstOrCreate([
            'name' => 'admin',
            'email' => 'admin@example.test',
            'password' => bcrypt('password'),
        ]);

        if (Role::where('name', 'Admin')->exists()) {
            $defaultUser->assignRole('Admin');
        }
    }
}
