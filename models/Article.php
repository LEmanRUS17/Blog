<?php

namespace app\models;

use app\models\ImageUpload;
use app\models\Category;
use Yii;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $content
 * @property string|null $date
 * @property string|null $image
 * @property int|null $viewed
 * @property int|null $user_id
 * @property int|null $status
 * @property int|null $category_id
 *
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],                              // Заголовок                       | Обязателен
            [['title',  'description', 'content'], 'string'],     // Заголовок, описание, содержание | Строка
            [['date'],  'date', 'format' => 'php: Y-m-d G:i'],    // Дата                            | Дата, формат: Год-месяц-день
            [['date'],  'default', 'value' => date('Y-m-d G:i')], // Дата                            | Значение по умолчанию: текущая дата
            [['title'], 'string', 'max' => 255],                  // Заголовок                       | Максимальное количество символов: 255
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'title'       => 'Заголовок статьи',
            'description' => 'Описание',
            'content'     => 'Текст',
            'date'        => 'Дата создания',
            'image'       => 'Изображение',
            'viewed'      => 'Просмотров',
            'user_id'     => 'ID Автора',
            'status'      => 'Статус',
            'category_id' => 'ID Категории',
        ];
    }

    public function saveImage($filename) // Сохранение файла
    {
        $this->image = $filename;
        return $this->save(false);
    }

    public function getImage() // получить Изображение
    {
        return ($this->image) ? '/uploads/' . $this->image : '/uploads/' . '/no-image.png';
    }

    public function deleteImage() // Удаление файла
    {
        $imageUploadModel = new ImageUpload;
        $imageUploadModel->deleteCurrentImage($this->image);
    }

    public function beforeDelete() // Запускается во время удаления файла
    {
        $this->deleteImage();
        return parent::beforeDelete(); 
    }

    public function getCategory() // Создание связи
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']); // Создание связи
    }

    public function saveCategory($category_id)
    {
        $category = Category::findOne($category_id);
        if($category != null) {
            $this->link('category', $category);
            return true;
        }
    }

    public function getTags() // Создание связи таблицы 
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id']);
    }

    public function getSelectedTags() // Получение списка тегов
    {
        $selectedIds = $this->getTags()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedIds, 'id');
    }

    public function saveTags($tags)
    {
        if (is_array($tags)) {
            $this->clearCurrentTags(); // Удаление старых тегов

            foreach ($tags as $tag_id) {
                $tag = Tag::findOne($tag_id);
                $this->link('tags', $tag);
            }
        }
    }

    public function clearCurrentTags()
    {
        ArticleTag::deleteAll(['article_id' => $this->id]);
    }

    public static function getAll($pageSize = 5) // Статичный метод для получени пагинации
    {
        // создать запрос к БД, чтобы получить все статьи
        $query      = Article::find();                           // Получение статей из БД
        $pagination = Article::getPagination($query, $pageSize); // Сформировать пагинацию

        return Article::ArticlesByPage($query, $pagination);
    }

    public static function getSearch($q, $pageSize = 5)
    {
        // создать запрос к БД, чтобы получить все статьи в заголовке которых присутствует значение переменной $q
        $query      = Article::find()->where(['like', 'title', $q]); // Поиск (like) в поле title по пораметру q
        $pagination = Article::getPagination($query, $pageSize);     // Сформировать пагинацию

        return Article::ArticlesByPage($query, $pagination);
    }

    public static function getPagination($query, $pageSize = 5, $forcePageParam = false, $pageSizeParam = false) // Сформировать пагинацию
    {
        $pagination = new Pagination(['totalCount' => $query->count(), // Передача количества
            'pageSize'       => $pageSize,       // Количество элементов на странице
            'forcePageParam' => $forcePageParam, 
            'pageSizeParam'  => $pageSizeParam
        ]);

        return $pagination;
    }

    public static function ArticlesByPage($query, $pagination)  // Сформировать Массив из статей с пагинацией
    {
        // ограничить запрос с помощью разбивки на страницы и получить статьи
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit) // Указание лимита выводимых записей на странице
            ->all();

        $data['articles']   = $articles;
        $data['pagination'] = $pagination;
    
        return $data;
    }

    public static function getPopular($limit = 3) // Получение популярных статей
    {
        return Article::find()->orderBy('viewed desc')->limit($limit)->all(); 
    }

    public static function getRecent($limit = 4) // Получение последних статей
    {
        return Article::find()->orderBy('date asc')->limit($limit)->all();
    }

    public function saveArticle()
    {
        $this->user_id = Yii::$app->user->id;
        return $this->save();
    }

    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['article_id' => 'id']);
    }

    public function getArticleComment()
    {
        return $this->getComments()->where(['status' => 1])->all();
    }

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function viewedCounter()
    {
        $this->viewed += 1;
        return $this->save(false);
    }


}