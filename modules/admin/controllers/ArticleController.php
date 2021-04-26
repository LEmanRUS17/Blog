<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Article;
use app\models\ArticleSearch;
use app\models\Category;
use app\models\ImageUpload;
use app\models\Tag;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() // Создание элемента
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $model->saveArticle()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionSetImage($id) // Добавление изображения
    {
        $model = new ImageUpload();

        if (Yii::$app->request->isPost) { // Если поступил запрос через метод Post

            $article = $this->findModel($id); // Запрос в базу для получения статьи
            $file = UploadedFile::getInstance($model, 'image'); // Загрузка изображения из формы

            if ($article->saveImage($model->uploadFile($file, $article->image))) // сохранение изображения в БД (Выполнение uploadFile(изображение из формы, изображение из статьи))
            {
                return $this->redirect(['view', 'id' => $article->id]);
            }
        }
        return $this->render('image', ['model' => $model]);
    }

    public function actionSetCategory($id)
    {
        $article = $this->findModel($id); // нахождение категории по id статьи
        
        $selectidCategory = $article->category->id; // id категорри статьи
        
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'title');

        if (Yii::$app->request->isPost) {
            $category = Yii::$app->request->post('category');
            
            if (true) {
                return $this->redirect(['view', 'id' => $article->id]);
            }
        }

        return $this->render('category', compact('article', 'selectidCategory', 'categories'));
    }

    public function actionSetTags($id)
    {
        $article = $this->findModel($id);                            // Получение статьи по $id
        
        $selectedTags = $article->getSelectedTags();                 // Получение списка тегов
        $tags = ArrayHelper::map(Tag::find()->all(), 'id', 'title'); // Получение тегов статьи

        if (Yii::$app->request->isPost) {
            $tags = Yii::$app->request->post('tags');
            $article->saveTags($tags);
            return $this->redirect(['view', 'id' => $article->id]);
        }

        return $this->render('tags', compact('article', 'selectedTags', 'tags'));
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    // http://html5up-striped.loc/admin/article/update?id= // id вводится пользователем
    public function actionUpdate($id) // Изменение статьи
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->saveArticle()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // http://html5up-striped.loc/admin/article/delete?id= // id вводится пользователем
    public function actionDelete($id) // Удаление Элемента
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
