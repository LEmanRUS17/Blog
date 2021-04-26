<?php

namespace app\models;

use yii\data\Pagination;
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string|null $title
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }

    public function getArticlesCount()
    {
        return $this->getArticles()->count();
    }

    public static function getAll()
    {
        return Category::find()->all(); // Получение всех категорий
    }

    public static function getArticleByCategory($id)
    {               
        // Формирование пагинации:
        // создать запрос к БД, чтобы получить все статьи
        $query = Article::find()->where(['category_id' => $id]); // Получение статей из БД

        // получить общее количество статей (но пока не получать данные о статьях) 
        $count = $query->count(); // Передача количества

        // создать объект разбивки на страницы с общим количеством 
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 5]); // Передача количества статей и максимального числа на странице

        // ограничить запрос с помощью разбивки на страницы и получить статьи 
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit) // Указание лимита выводимых записей на странице
            ->all();

        $data['articles']   = $articles;
        $data['pagination'] = $pagination;

        return $data;
    }
}
