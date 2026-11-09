<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddHelpdeskFieldsToPerbaikanAndLog extends Migration
{
    public function up()
    {
        // 1. Tambah kolom ke sarpras_perbaikan
        $fieldsPerbaikan = [
            'pelapor_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'barang_id',
            ],
            'teknisi_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'pelapor_id',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['menunggu', 'diproses', 'selesai', 'ditolak'],
                'default'    => 'menunggu',
                'after'      => 'teknisi_id',
            ],
            'tanggal_penanganan' => [
                'type'  => 'DATE',
                'null'  => true,
                'after' => 'status',
            ],
            'jam_penanganan' => [
                'type'  => 'TIME',
                'null'  => true,
                'after' => 'tanggal_penanganan',
            ],
            'deskripsi_penanganan' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'jam_penanganan',
            ],
        ];

        $this->forge->addColumn('sarpras_perbaikan', $fieldsPerbaikan);

        // 2. Buat tabel sarpras_perbaikan_log
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'perbaikan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'status_lama' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'status_baru' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at datetime default current_timestamp',
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('perbaikan_id');
        $this->forge->addKey('user_id');
        $this->forge->createTable('sarpras_perbaikan_log', true);
    }

    public function down()
    {
        $this->forge->dropTable('sarpras_perbaikan_log', true);
        $this->forge->dropColumn('sarpras_perbaikan', [
            'pelapor_id',
            'teknisi_id',
            'status',
            'tanggal_penanganan',
            'jam_penanganan',
            'deskripsi_penanganan',
        ]);
    }
}
