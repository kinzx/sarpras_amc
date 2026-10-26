<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSarprasTables extends Migration
{
    public function up()
    {
        // 1. Tabel Kategori (Induk)
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'nama_kategori' => ['type' => 'VARCHAR', 'constraint' => 100],
            'icon' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'is_active' => ['type' => 'BOOLEAN', 'default' => 1],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('sarpras_kategori', true);

        // 2. Tabel Sub Kategori (Baru)
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'kategori_id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true],
            'nama_sub_kategori' => ['type' => 'VARCHAR', 'constraint' => 100],
            'is_active' => ['type' => 'BOOLEAN', 'default' => 1],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kategori_id', 'sarpras_kategori', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('sarpras_sub_kategori', true);

        // 3. Tabel Ruang
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'nama_ruang' => ['type' => 'VARCHAR', 'constraint' => 100],
            'lantai' => ['type' => 'TINYINT', 'unsigned' => true, 'null' => true],
            'is_active' => ['type' => 'BOOLEAN', 'default' => 1],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('sarpras_ruang', true);

        // 4. Tabel Barang
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'kategori_id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true], // Wajib diisi
            'sub_kategori_id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'null' => true], // Boleh NULL
            'ruang_id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true],
            'kode_aset' => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'nama_barang' => ['type' => 'VARCHAR', 'constraint' => 150],
            'merek' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'tipe' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'no_seri' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'daya' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'tahun_pembelian' => ['type' => 'YEAR', 'null' => true],
            'interval_maintenance_hari' => ['type' => 'INT', 'unsigned' => true, 'null' => true, 'default' => 90],
            'foto' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'keterangan' => ['type' => 'TEXT', 'null' => true],
            'kepemilikan' => ['type' => 'ENUM', 'constraint' => ['milik_rs', 'milik_vendor'], 'default' => 'milik_rs'],
            'is_active' => ['type' => 'BOOLEAN', 'default' => 1],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kategori_id', 'sarpras_kategori', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('sub_kategori_id', 'sarpras_sub_kategori', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->addForeignKey('ruang_id', 'sarpras_ruang', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('sarpras_barang', true);

        // 5. Tabel Kalibrasi
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'barang_id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true],
            'tanggal_kalibrasi' => ['type' => 'DATE'],
            'file_sertifikat' => ['type' => 'VARCHAR', 'constraint' => 255],
            'catatan' => ['type' => 'TEXT', 'null' => true],
            'is_active' => ['type' => 'BOOLEAN', 'default' => 1],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('barang_id', 'sarpras_barang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('sarpras_kalibrasi', true);

        // 6. Tabel Maintenance
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'barang_id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tanggal_maintenance' => ['type' => 'DATE'],
            'kondisi_bodi' => ['type' => 'VARCHAR', 'constraint' => 255],
            'kondisi_display' => ['type' => 'VARCHAR', 'constraint' => 255],
            'kondisi_tombol' => ['type' => 'VARCHAR', 'constraint' => 255],
            'kondisi_aksesoris' => ['type' => 'VARCHAR', 'constraint' => 255],
            'kesimpulan' => ['type' => 'TEXT', 'null' => true],
            'foto_kondisi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'is_active' => ['type' => 'BOOLEAN', 'default' => 1],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('barang_id', 'sarpras_barang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('sarpras_maintenance', true);

        // 7. Tabel Perbaikan
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'barang_id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tanggal_perbaikan' => ['type' => 'DATE'],
            'laporan_kerusakan' => ['type' => 'TEXT'],
            'foto_sebelum' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'analisa_kerusakan' => ['type' => 'TEXT', 'null' => true],
            'tindakan_dilakukan' => ['type' => 'TEXT', 'null' => true],
            'kondisi_setelah' => ['type' => 'TEXT', 'null' => true],
            'kesimpulan' => ['type' => 'TEXT', 'null' => true],
            'is_active' => ['type' => 'BOOLEAN', 'default' => 1],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('barang_id', 'sarpras_barang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('sarpras_perbaikan', true);

        // 8. Tabel Log Apps
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'username' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'aksi' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'message' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'ipaddress' => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('log_apps');
    }

    public function down()
    {
        // Urutan drop dibalik dari yang paling anak ke induk
        $this->forge->dropTable('log_apps');
        $this->forge->dropTable('sarpras_perbaikan');
        $this->forge->dropTable('sarpras_maintenance');
        $this->forge->dropTable('sarpras_kalibrasi');
        $this->forge->dropTable('sarpras_barang');
        $this->forge->dropTable('sarpras_ruang');
        $this->forge->dropTable('sarpras_sub_kategori');
        $this->forge->dropTable('sarpras_kategori');
    }
}
