<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddModulToLogApps extends Migration
{
    public function up()
    {
        $fields = [
            "modul" => [
                "type" => "VARCHAR",
                "constraint" => 50,
                "null" => true,
                "after" => "username",
            ],
        ];

        $this->forge->addColumn("log_apps", $fields);
    }

    public function down()
    {
        $this->forge->dropColumn("log_apps", "modul");
    }
}
