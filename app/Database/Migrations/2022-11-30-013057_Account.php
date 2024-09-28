<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Account extends Migration
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
            'no_akun' => [
                'type'       => 'CHAR',
                'constraint' => '10',
            ],
            'saldo_normal' => [
                'type' => 'CHAR',
                'constraint' => '1',
            ],
            'level_account' => [
                'type' => 'INT',
                'constraint' => '',
            ],
            'account_name' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbaccount');
    }

    public function down()
    {
        $this->forge->dropTable('tbaccount');
    }
}