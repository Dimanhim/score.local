<?php

namespace app\controllers;

use app\models\Settings;
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
use app\models\Incomes;
use yii\data\Pagination;

class IncomesController extends Controller
{
    public function beforeAction($action)
    {
        $user = Yii::$app->user;
        if($user->isGuest AND $this->action->id !== 'login')
        {
            $user->loginRequired();
        }
        return true;
    }
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
        $set = new Settings();
        $model = Incomes::find()->where(['>=', 'date', $set->beginDate])->andWhere(['<', 'date', $set->endDate])->orderBy('date DESC');

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
        $model = new Incomes();
        if($model->load(Yii::$app->request->post())) {
            $model->date = time();
            if($model->income_default != null) {
                $model->name = IncomesDefault::findOne($model->income_default)->name;
                $model->category = IncomesDefault::findOne($model->income_default)->category;
            }
            else $model->income_default = 0;
            if($model->save()) {
                if(Scores::changeScore($model->income, $model->score)) {
                    Yii::$app->session->setFlash('success', "Доход успешно добавлен!");
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
        $model = Incomes::findOne($id);
        if($model->load(Yii::$app->request->post())) {
            if($model->save()) {
                Yii::$app->session->setFlash('success', "Доход успешно отредактирован!");
                return $this->redirect('index');
            }
            else {
                Yii::$app->session->setFlash('error', "Произошла ошибка сохранения!");
                return $this->redirect('index');
            }
        }
        $costs = Incomes::findOne($id);
        return $this->render('edit', [
            'model' => $model,
            'costs' => $costs,
        ]);
    }
    public function actionDelete($id)
    {
        $model = Incomes::findOne($id);
        if($model->delete()) {
            Yii::$app->session->setFlash('success', "Доход успешно удален!");
            return $this->redirect('index');
        }
        else {
            Yii::$app->session->setFlash('error', "Произошла ошибка удаления!");
            return $this->redirect('index');
        }
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
