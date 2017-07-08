<?php

namespace app\controllers;

use app\models\forms\MailForm;
use app\models\Mail;
use app\models\search\MailSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
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
     * @inheritdoc
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
     * Входящие письма
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
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

    /**
     * Список отправленных писем
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSent()
    {
        $model = Yii::createObject(MailSearch::className());

        $model->load(Yii::$app->request->get());

        return $this->render('sent', [
            'searchModel' => $model,
        ]);
    }

    /**
     * Новое письмо
     * @return string|Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionNewMail()
    {
        $model = Yii::createObject(MailForm::className());
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['sent']);
        } else {
            return $this->render('new-mail', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Удаление писем
     * @param $ids
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDeleteMail($ids)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $ids = explode('_', $ids);
            $result['status'] = 0;
            if (Mail::deleteAll(['id' => $ids])) {
                $result['status'] = 1;
            }
            return $result;
        } else {
            throw new NotFoundHttpException;
        }
    }

    /**
     * Получение данных для просмотра содержимого письма в модальном окне
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionGetMailData($id)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result['status'] = 0;
            if ($model = Mail::find()->andWhere(['id' => $id])->limit(1)->one()) {
                $result = [
                    'status' => 1,
                    'html' => $this->renderPartial('_partial/_mail_data', ['model' => $model])
                ];
            }
            return $result;
        } else {
            throw new NotFoundHttpException;
        }
    }
}
