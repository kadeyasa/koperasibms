<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kodetransaksi extends Migration
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
            'kode_transaksi' => [
                'type' => 'CHAR',
                'constraint' => '50',
            ],
            'nama_transaksi' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'status' => [
                'type' => 'INT',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbkodetransaksi');
    }

    public function down()
    {
        $this->forge->dropTable('tbkodetransaksi');
    }
}