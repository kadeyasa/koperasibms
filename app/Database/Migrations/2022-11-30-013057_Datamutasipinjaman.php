<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Datamutasipinjaman extends Migration
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
            'debet' => [
                'type'       => 'FLOAT',
                'constraint' => '',
            ],
            'kredit' => [
                'type'       => 'FLOAT',
                'constraint' => '',
            ],
            'balance' => [
                'type'       => 'FLOAT',
                'constraint' => '',
            ],
            'status' => [
                'type' => 'INT',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbdatamutasipinjaman');
    }

    public function down()
    {
        $this->forge->dropTable('tbdatamutasipinjaman');
    }
}