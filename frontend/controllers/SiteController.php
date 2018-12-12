<?php

namespace frontend\controllers;

use common\models\LoginForm;
use common\models\auth\AuthCode;
use common\services\mail\MailService;
use common\services\user\UserService;
use frontend\forms\AuthForm;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Class SiteController
 * @package frontend\controllers
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
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
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @param $authCode
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionLogin($authCode)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (!$authCode) {
            Yii::$app->session->setFlash('success', 'Не верная ссылка для авторизации.');
            return $this->redirect(['site/auth']);
        }

        $auth = AuthCode::find()
            ->andWhere(['auth_code' => $authCode])
            ->andWhere(['status' => AuthCode::STATUS_ACTIVE])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        if (!$auth) {
            $message = 'Неверная ссылка или ссылка уже была использована. Пожалуйста повторите процесс авторизации.';
            Yii::$app->session->setFlash('danger', $message);
            return $this->redirect(['site/auth']);
        }

        if (!$auth->user) {
            $userService = new UserService();
            if (!$userService->create($auth->email)) {
                Yii::$app->session->setFlash('danger', 'Ошибка создания нового пользователя.');
                return $this->redirect(['site/auth']);
            }
        }

        $model = new LoginForm();
        $model->email = $auth->email;

        try {
            if ($model->login()) {
                $auth->setStatusUses();
                $auth->save();
                return $this->goBack();
            }
        } catch (\Exception $exception) {
            Yii::$app->session->setFlash('danger', 'Ошибка авторизации. Пожалуйства попробуйте еще раз.');
            return $this->redirect(['site/auth']);
        }

        return $this->redirect(['site/auth']);
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function actionAuth()
    {
        $authForm = new AuthForm();
        $authForm->setScenarioEmail();

        if ($authForm->load(Yii::$app->request->post()) && $authForm->validate()) {
            $mailService = new MailService();
            $mailService->sendMessageAuth($authForm->email);
        }

        return $this->render('auth', [
            'authForm' => $authForm,
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
