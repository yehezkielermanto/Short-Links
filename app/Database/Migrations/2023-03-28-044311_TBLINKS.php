<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use function PHPSTORM_META\type;

class TBLINKS extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'url_ori' => [
                'type' => 'TEXT',
            ],
            'url_short' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME'
            ],
            'updated_at' => [
                'type' => 'DATETIME'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id','tb_user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_links');
    }

    public function down()
    {
        $this->forge->dropTable('tb_links');
    }
}
