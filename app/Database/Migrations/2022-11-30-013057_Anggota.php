<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Anggota extends Migration
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
            'no_anggota' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'alamat' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'jenis_kelamin' => [
                'type'       => 'CHAR',
                'constraint' => '2',
            ],
            'no_telp' => [
                'type'       => 'CHAR',
                'constraint' => '20',
            ],
            'nik' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'jenis_anggota' => [
                'type'       => 'CHAR',
                'constraint' => '5',
            ],
            'produk_key' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'photo_ktp' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'status' => [
                'type' => 'INT',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbanggota');
    }

    public function down()
    {
        $this->forge->dropTable('tbanggota');
    }
}