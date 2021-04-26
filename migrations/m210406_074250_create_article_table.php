<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article}}`.
 */
class m210406_074250_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Создание полей таблицы:
        $this->createTable('{{%article}}', [
            'id'          => $this->primaryKey(), // Основной ключ - id Элемента
            'title'       => $this->string(),     // Строка        - Заголовок
            'description' => $this->text(),       // Текст         - Описание 
            'content'     => $this->text(),       // Текст         - Содержимое
            'date'        => $this->dateTime(),   // Дата          - Дата создания
            'image'       => $this->string(),     // Строка        - Изображение
            'viewed'      => $this->integer(),    // Целое число   - Количество просмотров
            'user_id'     => $this->integer(),    // Целое число   - Автор
            'status'      => $this->integer(),    // Целое число   - Статус
            'category_id' => $this->integer(),    // Целое число   - Категория
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%article}}');
    }
}
