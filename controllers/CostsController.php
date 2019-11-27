<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Scores;
use app\models\Categories;
use app\models\Costs;
use app\models\CostsDefault;
use app\models\IncomesDefault;
use yii\data\Pagination;

class CostsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */


    //------------------------------------- РАСХОДЫ
    public function actionIndex()
    {
        $model = Costs::find()->orderBy('date DESC')->where('date' > Scores::getTimeBeginMonth());

        // Пагинация
        $pagination = new Pagination(
            [
                'defaultPageSize' => 10,
                'totalCount' => $model->count(),
            ]
        );
        $model = $model->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index', [
            'model' => $model,
            'pagination' => $pagination,
        ]);
    }
    public function actionAdd()
    {
        $model = new Costs();
        if($model->load(Yii::$app->request->post())) {
            $model->date = time();
            if($model->costs_default != 0) {
                $model->name = CostsDefault::findOne($model->costs_default)->name;
                $model->category = CostsDefault::findOne($model->costs_default)->category;
            }
            else $model->costs_default = 0;
            $category_child = $model->category_child;
            if($category_child) $model->category = $category_child;
            if($model->save()) {
                if(Scores::changeScore('-'.$model->cost, $model->score)) {
                    Yii::$app->session->setFlash('success', "Расход успешно добавлен!");
                    return $this->redirect('index');
                }
                else {
                    Yii::$app->session->setFlash('error', "Произошла ошибка сохранения!");
                    return $this->redirect('index');
                }
            }
        }
        return $this->render('add', [
            'model' => $model,
        ]);
    }
    public function actionEdit($id)
    {
        $model = Costs::findOne($id);
        if($model->load(Yii::$app->request->post())) {
            if($model->save()) {
                Yii::$app->session->setFlash('success', "Расход успешно отредактирован!");
                return $this->redirect('index');
            }
            else {
                Yii::$app->session->setFlash('error', "Произошла ошибка сохранения!");
                return $this->redirect('index');
            }
        }
        $costs = Costs::findOne($id);
        return $this->render('edit', [
            'model' => $model,
            'costs' => $costs,
        ]);
    }
    public function actionDelete($id)
    {
        $model = Costs::findOne($id);
        if($model->delete()) {
            Yii::$app->session->setFlash('success', "Расход успешно удален!");
            return $this->redirect('index');
        }
        else {
            Yii::$app->session->setFlash('error', "Произошла ошибка удаления!");
            return $this->redirect('index');
        }
    }
//---AJAX
    public function actionGetSubCats()
    {
        $id = Yii::$app->request->post('id');
        if($id) {
            $option = '';
            $cats = Categories::find()->where(['parent' => $id])->all();
            if($cats) {
                foreach($cats as $cat) {
                    $option .= '<option value="'.$cat->id.'">'.$cat->name.'</option>';
                }
            }
        }
        return $option;
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
