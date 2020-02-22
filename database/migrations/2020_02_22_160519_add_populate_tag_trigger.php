<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddPopulateTagTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE TRIGGER `populate_tags` AFTER INSERT ON `tasks` FOR EACH ROW BEGIN
                        INSERT INTO tags(tag, task_id) VALUES(CAST(NEW.order_id AS CHAR(191)), NEW.id);
                        INSERT INTO tags(tag, task_id) VALUES(NEW.subject, NEW.id);
                        INSERT INTO tags(tag, task_id) VALUES(NEW.title, NEW.id);
                        INSERT INTO tags(tag, task_id) VALUES(NEW.case_study, NEW.id);
                    END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `populate_tag`');
    }
}
