<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m210406_074314_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Создание полей таблицы:
        $this->createTable('{{%category}}', [
            'id'    => $this->primaryKey(), // Основной ключ - id Элемента
            'title' => $this->string(),     // Строка        - Заголовок
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
}
