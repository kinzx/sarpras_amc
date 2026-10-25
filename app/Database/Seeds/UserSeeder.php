<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        // Buat user baru
        $user = new User();
        $user->username = 'admin';
        $user->email    = 'admin@rsamc.com';
        $user->password = '123456';
        $user->active   = 1;

        $userModel->save($user);
        
        // Ambil ID user yang baru dibuat
        $userId = $userModel->getInsertID();

        // Masukkan ke grup admin (ID 1)
        $this->db->table('auth_groups_users')->insert([
            'group_id' => 1,
            'user_id'  => $userId,
        ]);
    }
}