<?php

namespace app\controllers;

use app\models\Article;
use app\models\ArticleTag;
use app\models\Tag;
use app\models\Category;
use app\models\Comment;
use app\models\CommentForm;
use Yii;
use yii\data\Pagination;

class HomeController extends AppController
{
    // http://html5up-striped.loc/
    public function actionIndex()
    {
        $data = Article::getAll(5);

        return $this->render('index', [
            'articles'   => $data['articles'],
            'pagination' => $data['pagination'],
        ]);
    }

    // http://html5up-striped.loc/home/single
    public function actionSingle($id)
    {
        $article     = Article::findOne($id);                              // Получение поста по id
        $tags        = Tag::findAll(['id' => ArticleTag::tagListId($id)]); // Запрос в таблицу tag для получения записей
        $comments    = $article->getArticleComment();                      // Получение коментариев поста
        $commentForm = new CommentForm();                                  // Форма для сознания коментария

        $article->viewedCounter();
        
        return $this->render('single', compact('article', 'tags', 'comments', 'commentForm'));
    }

    // http://html5up-striped.loc/home/category
    public function actionCategory($id) // Получить список статей по категориям
    {
        $data = Category::getArticleByCategory($id);

        return $this->render('category', $data);
    }

    public function actionComment($id)
    {
        $model = new CommentForm();
        
        if(Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->request->post());
            if($model->saveComment($id))
            {
                Yii::$app->getSession()->setFlash('comment', 'Your comment will be added soon!');
                return $this->redirect(['home/single','id'=>$id]);
            }
        }
    }

    public function actionSearch($q) // Поиск статей по названию
    {
        $q = trim(\Yii::$app->request->get('q')); // Получение запроса для поиска

        $this->setMeta("Поиск: {$q} ::" . \Yii::$app->name); // Формирование title страницы

        if(!$q) { // Если переменная для поиска пустая
            return $this->render('search'); // Вывести пустую страницу
        }

        $data = Article::getSearch($q, 2); // Рузультат поиска

        return $this->render('search', [
            'articles'   => $data['articles'],
            'pagination' => $data['pagination'],
            'q' => $q,
        ]);
    }
}