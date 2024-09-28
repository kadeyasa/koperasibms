<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Datapinjaman extends Migration
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
                'type' => 'CHAR',
                'constraint' => '15',
                'null' => true,
            ],
            'rek_pinjaman' => [
                'type'       => 'CHAR',
                'constraint' => '50',
            ],
            'jenis_pinjaman' => [
                'type'       => 'INT',
                'constraint' => '50',
            ],
            'lama_pinjaman' => [
                'type'       => 'FLOAT',
                'constraint' => '',
            ],
            'jumlah_pokok' => [
                'type'       => 'FLOAT',
                'constraint' => '',
            ],
            'jumlah_bunga' => [
                'type'       => 'FLOAT',
                'constraint' => '',
            ],
            'tgl' => [
                'type'       => 'DATE',
                'constraint' => '',
            ],
            'jumlah' => [
                'type'       => 'FLOAT',
                'constraint' => '',
            ],
            'sisa_pinjaman' => [
                'type'       => 'FLOAT',
                'constraint' => '',
            ],
            'status' => [
                'type' => 'INT',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbdatapinjaman');
    }

    public function down()
    {
        $this->forge->dropTable('tbdatapinjaman');
    }
}