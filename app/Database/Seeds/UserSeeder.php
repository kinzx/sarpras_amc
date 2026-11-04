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
        $groupModel = new \Myth\Auth\Models\GroupModel();

        // Pastikan group superadmin, admin, admin_teknisi, dan teknisi ada
        $groups = [
            ["id" => 1, "name" => "admin", "description" => "IT dan Manajemen"],
            [
                "id" => 2,
                "name" => "teknisi",
                "description" => "Teknisi Lapangan",
            ],
            [
                "id" => 3,
                "name" => "superadmin",
                "description" => "Super Admin Sistem",
            ],
            [
                "id" => 4,
                "name" => "admin_teknisi",
                "description" => "Admin Teknisi Sarpras",
            ],
        ];
        foreach ($groups as $g) {
            $exists = $this->db
                ->table("auth_groups")
                ->where("id", $g["id"])
                ->countAllResults();
            if ($exists === 0) {
                $this->db->table("auth_groups")->insert($g);
            }
        }

        $akunList = [
            [
                "username" => "superadmin",
                "email" => "superadmin@rsamc.com",
                "group" => "superadmin",
            ],
            [
                "username" => "admin",
                "email" => "admin@rsamc.com",
                "group" => "admin",
            ],
            [
                "username" => "admin.teknisi",
                "email" => "admin.teknisi@rsamc.com",
                "group" => "admin_teknisi",
            ],
            [
                "username" => "teknisi.budi",
                "email" => "budi.teknisi@rsamc.com",
                "group" => "teknisi",
            ],
            [
                "username" => "teknisi.andi",
                "email" => "andi.teknisi@rsamc.com",
                "group" => "teknisi",
            ],
            [
                "username" => "teknisi.fajar",
                "email" => "fajar.teknisi@rsamc.com",
                "group" => "teknisi",
            ],
            [
                "username" => "teknisi.dodi",
                "email" => "dodi.teknisi@rsamc.com",
                "group" => "teknisi",
            ],
            [
                "username" => "teknisi.agus",
                "email" => "agus.teknisi@rsamc.com",
                "group" => "teknisi",
            ],
            [
                "username" => "teknisi.hendra",
                "email" => "hendra.teknisi@rsamc.com",
                "group" => "teknisi",
            ],
            [
                "username" => "teknisi.rizky",
                "email" => "rizky.teknisi@rsamc.com",
                "group" => "teknisi",
            ],
        ];

        foreach ($akunList as $item) {
            $existing = $userModel
                ->where("username", $item["username"])
                ->orWhere("email", $item["email"])
                ->first();

            if (!$existing) {
                $user = new User();
                $user->username = $item["username"];
                $user->email = $item["email"];
                $user->password = "123456";
                $user->active = 1;
                $userModel->save($user);

                $userId = $userModel->getInsertID();
            } else {
                $userId = $existing->id;
            }

            // Assign ke group
            $groupRow = $this->db
                ->table("auth_groups")
                ->where("name", $item["group"])
                ->get()
                ->getRow();
            if ($groupRow) {
                $hasGroup = $this->db
                    ->table("auth_groups_users")
                    ->where("user_id", $userId)
                    ->where("group_id", $groupRow->id)
                    ->countAllResults();

                if ($hasGroup === 0) {
                    $this->db->table("auth_groups_users")->insert([
                        "group_id" => $groupRow->id,
                        "user_id" => $userId,
                    ]);
                }
            }
        }
    }
}
