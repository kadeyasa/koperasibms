<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Simpanananggota extends Migration
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
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'id_jenis_simpanan' => [
                'type' => 'INT',
                'constraint' => '',
            ],
            'tgl' => [
                'type'       => 'DATE',
                'constraint' => '',
            ],
            'tgl_jatuh_tempo' => [
                'type'       => 'DATE',
                'constraint' => '',
            ],
            'jumlah' => [
                'type'       => 'FLOAT',
                'constraint' => '',
            ],
            'status' => [
                'type' => 'INT',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbsimpanananggota');
    }

    public function down()
    {
        $this->forge->dropTable('tbsimpanananggota');
    }
}