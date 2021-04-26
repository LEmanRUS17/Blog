<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m210406_074342_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Создание полей таблицы:
        $this->createTable('{{%user}}', [
            'id'       => $this->primaryKey(),                 // Основной ключ - id Элемента
            'name'     => $this->string(),                     // Строка        - Логин пользователя
            'email'    => $this->string()->defaultValue(null), // Email         - Email пользователя
            'password' => $this->string(),                     // Строка        - Пароль
            'isAdmin'  => $this->integer()->defaultValue(0),   // Целое число   - Статус пользователя
            'photo'    => $this->string()->defaultValue(null), // Строка        - Аватар пользователя
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
