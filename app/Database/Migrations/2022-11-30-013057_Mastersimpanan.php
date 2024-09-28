<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mastersimpanan extends Migration
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
            'id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'nama_simpanan' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'jangka' => [
                'type'       => 'float',
                'constraint' => '',
            ],
            'bunga' => [
                'type'       => 'FLOAT',
                'constraint' => '',
            ],
            'status' => [
                'type' => 'INT',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbsetupsimpanan');
    }

    public function down()
    {
        $this->forge->dropTable('tbsetupsimpanan');
    }
}