<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_pdf_queue_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'status' => ['type' => "ENUM('pending','processing','done','error')", 'default' => 'pending'],
            'student_ids' => ['type' => 'TEXT', 'null' => TRUE],
            'exam_id' => ['type' => 'INT', 'null' => TRUE],
            'class_id' => ['type' => 'INT', 'null' => TRUE],
            'section_id' => ['type' => 'INT', 'null' => TRUE],
            'session_id' => ['type' => 'INT', 'null' => TRUE],
            'branch_id' => ['type' => 'INT', 'null' => TRUE],
            'template_id' => ['type' => 'INT', 'null' => TRUE],
            'print_date' => ['type' => 'DATE', 'null' => TRUE],
            'file_path' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'error' => ['type' => 'TEXT', 'null' => TRUE],
            'created_at' => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP'],
            'updated_at' => [
                'type' => 'DATETIME',
                'default' => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP'
            ],
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('pdf_queue');
    }

    public function down()
    {
        $this->dbforge->drop_table('pdf_queue');
    }
}
