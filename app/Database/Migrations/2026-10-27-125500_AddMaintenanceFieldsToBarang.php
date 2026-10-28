<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMaintenanceFieldsToBarang extends Migration
{
    public function up()
    {
        $fields = [];

        if (!$this->db->fieldExists('tanggal_perbaikan_terakhir', 'sarpras_barang')) {
            $fields['tanggal_perbaikan_terakhir'] = [
                'type'  => 'DATE',
                'null'  => true,
                'after' => 'interval_maintenance_hari',
            ];
        }

        if (!$this->db->fieldExists('kondisi_barang', 'sarpras_barang')) {
            $fields['kondisi_barang'] = [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'default'    => 'Baik',
                'after'      => 'tanggal_perbaikan_terakhir',
            ];
        }

        if ($fields !== []) {
            $this->forge->addColumn('sarpras_barang', $fields);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('kondisi_barang', 'sarpras_barang')) {
            $this->forge->dropColumn('sarpras_barang', 'kondisi_barang');
        }

        if ($this->db->fieldExists('tanggal_perbaikan_terakhir', 'sarpras_barang')) {
            $this->forge->dropColumn('sarpras_barang', 'tanggal_perbaikan_terakhir');
        }
    }
}
