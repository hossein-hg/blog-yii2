<?php

namespace app\controllers;
use Yii;
use app\models\Post;
use app\models\PostSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index', 'view', 'create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['admin'], // دسترسی کامل برای admin
                        ],
                        [
                            'actions' => ['view', 'create','index'],
                            'allow' => true,
                            'roles' => ['author'], // فقط view و create برای author
                        ],
                        [
                            'actions' => ['index', 'view', 'create', 'update', 'delete'],
                            'allow' => false, // عدم دسترسی برای کاربران معمولی
                            'roles' => ['?'], // کاربران مهمان یا بدون نقش
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        throw new \yii\web\ForbiddenHttpException('شما اجازه دسترسی به این بخش را ندارید.');
                    },
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Post models.
     *
     * @return string
     */
    public function actionIndex()
    {
       
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($this->request->isPost) {
            $model->author_id = Yii::$app->user->id;
            if ($model->load($this->request->post())  && $model->upload()  && $model->save()) {
                
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
    // if (!Yii::$app->user->can('updatePost')) {
    //     throw new ForbiddenHttpException('شما اجازه ویرایش پست را ندارید.');
    // }
    $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $oldImagePath = $model->image_path; // ذخیره مقدار قبلی image_path
                if ($model->upload()) {
                    // اگر تصویر جدیدی آپلود نشده، مقدار قبلی حفظ شود
                    if (!$model->imageFile) {
                        $model->image_path = $oldImagePath;
                    }
                    $model->author_id = Yii::$app->user->id;
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'پست با موفقیت به‌روزرسانی شد.');
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        \Yii::error('خطای ذخیره‌سازی مدل: ' . print_r($model->errors, true));
                        var_dump($model->errors);
                        exit;
                    }
                } else {
                    \Yii::error('خطای آپلود: ' . print_r($model->errors, true));
                    var_dump($model->errors);
                    exit;
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // if (!Yii::$app->user->can('deletePost')) {
        //     throw new ForbiddenHttpException('شما اجازه ویرایش پست را ندارید.');
        // }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
