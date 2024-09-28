<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jurnal extends Migration
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
            'date' => [
                'type'       => 'DATE',
                'constraint' => '',
            ],
            'kode_akun' => [
                'type' => 'CHAR',
                'constraint' => '10',
            ],
            'uraian' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'debet' => [
                'type' => 'FLOAT',
                'constraint' => '',
            ],
            'kredit' => [
                'type' => 'FLOAT',
                'constraint' => '',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbjurnal');
    }

    public function down()
    {
        $this->forge->dropTable('tbjurnal');
    }
}