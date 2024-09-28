<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Profilekoperasi extends Migration
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
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'alamat' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'no_telp' => [
                'type'       => 'CHAR',
                'constraint' => '20',
            ],
            'no_akta' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'tgl_berdiri' => [
                'type'       => 'DATE',
                'constraint' => '',
            ],
            'produk_key' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'active_until' => [
                'type'       => 'DATETIME',
                'constraint' => '',
            ],
            'status' => [
                'type' => 'INT',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbprofilekoperasi');
    }

    public function down()
    {
        $this->forge->dropTable('tbprofilekoperasi');
    }
}