<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Neraca extends Migration
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
            'bulan' => [
                'type'       => 'CHAR',
                'constraint' => '4',
            ],
            'tahun' => [
                'type' => 'CHAR',
                'constraint' => '4',
            ],
            'balance' => [
                'type' => 'FLOAT',
                'constraint' => '',
            ],
            'is_awal' => [
                'type' => 'TINYINT',
                'constraint' => '',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbneraca');
    }

    public function down()
    {
        $this->forge->dropTable('tbneraca');
    }
}