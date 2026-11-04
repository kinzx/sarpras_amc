<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTeknisiPendampingToMaintenanceAndPerbaikan extends Migration
{
    public function up()
    {
        $fields = [
            "teknisi_pendamping" => [
                "type" => "TEXT",
                "null" => true,
                "after" => "user_id",
            ],
        ];

        $this->forge->addColumn("sarpras_maintenance", $fields);
        $this->forge->addColumn("sarpras_perbaikan", $fields);
    }

    public function down()
    {
        $this->forge->dropColumn("sarpras_maintenance", "teknisi_pendamping");
        $this->forge->dropColumn("sarpras_perbaikan", "teknisi_pendamping");
    }
}
