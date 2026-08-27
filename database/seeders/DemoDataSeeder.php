<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DemoDataSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Create ~15 varied demo users with roles and posts.
     */
    public function run(): void
    {
        // Ensure the "User" role exists (Admin & Manager are created by RolePermissionSeeder).
        $userRole = Role::firstOrCreate(['name' => 'User']);
        $userRole->syncPermissions(['post-create', 'post-view', 'post-edit']);

        $names = [
            'Aarav Sharma', 'Diya Patel', 'Vivaan Mehta', 'Ananya Singh', 'Kabir Verma',
            'Isha Kapoor', 'Reyansh Rao', 'Myra Nair', 'Arjun Reddy', 'Saanvi Das',
            'Vihaan Bose', 'Aadhya Menon', 'Krishna Iyer', 'Navya Joshi', 'Rudra Kulkarni',
        ];

        foreach ($names as $i => $name) {
            $email = strtolower(str_replace(' ', '.', $name)) . '@example.com';

            $user = User::factory()->create([
                'name' => $name,
                'email' => $email,
            ]);

            // Varied role assignment for a realistic mix.
            if ($i === 0) {
                $user->assignRole('Admin');
            } elseif ($i < 4) {
                $user->assignRole('Manager');
            } elseif ($i < 12) {
                $user->assignRole('User');
            }
            // Remaining users (i >= 12) intentionally get NO role.

            // Varied post counts (some users have 0 posts).
            $postCount = match (true) {
                $i % 5 === 0 => 0,
                $i % 3 === 0 => rand(1, 2),
                default => rand(2, 6),
            };

            for ($p = 0; $p < $postCount; $p++) {
                Post::create([
                    'title' => fake()->sentence(4),
                    'content' => fake()->paragraph(3),
                    'user_id' => $user->id,
                    'image' => null,
                ]);
            }
        }
    }
}
