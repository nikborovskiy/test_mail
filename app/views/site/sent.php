<?php
use yii\grid\GridView;
use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\widgets\Pjax;

/**
 * @var \yii\web\View $this
 * @var \app\models\search\MailSearch $searchModel
 */
?>
<div class="sent-mail-wrap">
    <?= $this->render('_partial/_buttons'); ?>
    <br/>
    <?php Pjax::begin(['id' => 'mail-table-pjax']) ?>
    <?= GridView::widget([
        'dataProvider' => $searchModel->search(),
        'filterModel' => $searchModel->filter(),
        'summary' => false,
        'options' => [
            'class' => 'grid-view js-sent-mail-table'
        ],
        'columns' => [
            [
                'attribute' => 'id',
                'header' => Html::checkbox('select-all-mail', false, ['class' => 'js-all-mail']),
                'value' => function ($data) {
                    return Html::checkbox('mail-' . $data->id, false, ['data-id' => $data->id, 'class' => 'js-mail-item']);
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'email',
                'value' => function ($data) {
                    return Html::a($data->email, 'javascript://', ['class' => 'js-link-view', 'data-id' => $data->id]);
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'theme',
                'value' => function ($data) {
                    return Html::a($data->theme, 'javascript://', ['class' => 'js-link-view', 'data-id' => $data->id]);
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel->filter(),
                    'attribute' => 'created_at',
                    'pluginOptions' => [
                        'todayHighlight' => true
                    ]
                ])
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<div class="modal fade" id="mail-data" tabindex="-1" role="dialog" aria-labelledby="mail-data-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="mail-data-label">Просмотр  подробностей письма</h4>
            </div>
            <div class="modal-body js-modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>


