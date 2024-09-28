<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Masterbiayapinjaman extends Migration
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
            'nama_biaya' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'jenis_biaya' => [
                'type'       => 'FLOAT',
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
        $this->forge->createTable('tbbiayapinjaman');
    }

    public function down()
    {
        $this->forge->dropTable('tbbiayapinjaman');
    }
}