<?php

use yii\db\Migration;

/**
 * Class m210420_124222_add_date_to_comment
 */
class m210420_124222_add_date_to_comment extends Migration
{

    public function up()
    {
        $this->addColumn('comment', 'date', $this->dateTime());
    }

    public function down()
    {
        $this->dropColumn('comment', 'date');
    }
}
