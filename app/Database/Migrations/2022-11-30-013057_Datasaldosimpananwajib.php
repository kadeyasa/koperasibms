<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Datasaldosimpananwajib extends Migration
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
                'type' => 'INT',
                'constraint' => '',
            ],
            'total_saldo' => [
                'type'       => 'FLOAT',
                'constraint' => '',
            ],
            'status' => [
                'type' => 'INT',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbdatasaldosimpananwajib');
    }

    public function down()
    {
        $this->forge->dropTable('tbdatasaldosimpananwajib');
    }
}