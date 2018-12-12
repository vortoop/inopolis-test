<?php

use yii\helpers\Html;

/**
 * @var $modelForm \frontend\forms\UserForm
 */

$this->title = 'Личные данные';
?>

<div class="modal fade" id="personal-form-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Вы действительно хотите изменить имя пользователя?</h4>
            </div>
            <div class="modal-body text-right">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                <button type="button" class="btn btn-primary js__change-username">Продолжить</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <?php $form = \yii\widgets\ActiveForm::begin(['id' => 'personal-form', 'method' => 'post']) ?>

        <?= $form->field($modelForm, 'username')->textInput(['autofocus' => true]) ?>

        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?php \yii\widgets\ActiveForm::end() ?>
    </div>
    <div class="col-md-6"></div>
</div>
