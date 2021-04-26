<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article_tag".
 *
 * @property int $id
 */
class ArticleTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        ];
    }

    public static function tagListId($id) // Получить список id тегов поста
    {
        $article_tag = ArticleTag::find()  // Запрос в таблицу article_tag
            ->select('tag_id')             // Записи из столбца tag_id
            ->where(['article_id' => $id]) // Выбор записей значение столбца article_id которых равно id
            ->asArray()                    // Сформировать массив
            ->all();                       // Получить все записи

        // Преобразование результата $article_tag в одномернаы массив:
        foreach ($article_tag as $tag) {
            $tagList[] = $tag['tag_id'];
        }

        return $tagList;
    }
}
