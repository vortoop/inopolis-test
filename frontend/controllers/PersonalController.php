<?php

namespace frontend\controllers;

use common\models\User;
use common\services\user\UserService;
use frontend\forms\UserForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class PersonalController
 * @package frontend\controllers
 */
class PersonalController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionIndex()
    {
        $model = $this->findModel(\Yii::$app->user->id);
        $modelForm = new UserForm();
        $modelForm->setAttributes($model->getAttributes());

        if ($modelForm->load(\Yii::$app->request->post()) && $modelForm->validate()) {
            $userService = new UserService($model);
            try {
                $userService->update($modelForm->attributes);
                \Yii::$app->session->setFlash('success', 'Профиль успешно обновлен');

                return $this->redirect(['/personal']);
            } catch (\Exception $exception) {
                \Yii::$app->session->setFlash('danger', 'Возникла ошибка при обновлении профиля');
            }
        }

        return $this->render('index', [
            'modelForm' => $modelForm
        ]);
    }

    /**
     * @param $id
     * @return User|null
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = User::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Пользователь не найден');
        }

        return $model;
    }
}
