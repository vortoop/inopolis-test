<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $authForm \frontend\forms\AuthForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h3><?= Html::encode($this->title) ?></h3>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'auth-form']); ?>

            <?php if ($authForm->isAssignEmailScenario()): ?>
                <?= $form->field($authForm, 'email')->textInput(['autofocus' => true]) ?>
            <?php else: ?>
                <?= $form->field($authForm, 'password')->passwordInput() ?>
            <?php endif; ?>

            <div class="form-group">
                <?= Html::submitButton('Авторизация', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
