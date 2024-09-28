<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Permohonanpinjaman extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'created_at' => [
                'type'       => 'TIMESTAMP',
                'constraint' => '',
            ],
            'updated_at' => [
                'type'       => 'TIMESTAMP',
                'constraint' => '',
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
                'constraint' => '',
                'null' => true,
            ],
            'id_anggota' => [
                'type'       => 'INT',
                'constraint' => '',
                'NULL'=>true
            ],
            'jenis_pinjaman' => [
                'type' => 'INT',
                'constraint' => '',
            ],
            'tgl_pengajuan' => [
                'type' => 'INT',
                'constraint' => '',
            ],
            'jumlah' => [
                'type' => 'FLOAT',
                'constraint' => '',
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => '',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbpengajuanpinjaman');
    }

    public function down()
    {
        $this->forge->dropTable('tbpengajuanpinjaman');
    }
}