<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Dataangsuranpinjaman extends Migration
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
            'id_pinjaman' => [
                'type' => 'INT',
                'constraint' => '',
                'null' => true,
            ],
            'tgl' => [
                'type'       => 'DATE',
                'constraint' => '',
            ],
            'jumlah_bunga' => [
                'type'       => 'FLOAT',
                'constraint' => '',
            ],
            'jumlah_pokok' => [
                'type'       => 'FLOAT',
                'constraint' => '',
            ],
            'status' => [
                'type' => 'INT',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbdataangsuranpinjaman');
    }

    public function down()
    {
        $this->forge->dropTable('tbdataangsuranpinjaman');
    }
}