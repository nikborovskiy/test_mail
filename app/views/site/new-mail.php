<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var \app\models\forms\MailForm $model
 */
?>
<h1>Отправка нового письма</h1>

<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
]); ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'theme')->textInput() ?>

<?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>


<div class="row">
    <div class="col-md-9 text-right">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Отменить', ['/site/index'], ['class' => 'btn btn-default']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
