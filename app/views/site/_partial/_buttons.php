<?php
use yii\helpers\Html;

?>
<div class="mail-buttons">
    <?= Html::a('Написать письмо', ['/site/new-mail'], ['class' => 'btn btn-primary']); ?>
    <?php if (Yii::$app->controller->action->id == 'sent'): ?>
        <?= Html::button('Удалить выбранные письма', ['class' => 'btn btn-danger js-delete-mail-button disabled']); ?>
    <?php endif; ?>
</div>


