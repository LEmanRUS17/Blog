<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tag}}`.
 */
class m210406_074328_create_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Создание полей таблицы:
        $this->createTable('{{%tag}}', [
            'id'    => $this->primaryKey(), // Основной ключ - id Элемента
            'title' => $this->string(),     // Строка        - Заголовок
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tag}}');
    }
}
