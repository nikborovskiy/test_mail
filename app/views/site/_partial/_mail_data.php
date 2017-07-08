<?php
use app\models\Mail;
use yii\widgets\DetailView;

/**
 * @var Mail $model
 */
?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'email',
        'theme',
        'text:ntext',
        'created_at:datetime'
    ],
]); ?>