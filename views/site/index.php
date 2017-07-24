<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Ad;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">



    <div class="ad-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <?php if(!\Yii::$app->user->isGuest):?>
            <?= Html::a('Create Ad', \Yii::$app->urlManager->createUrl(['ad/create']), ['class' => 'btn btn-success']) ?>
        <?php endif;?>

        <?php Pjax::begin(); ?>
        <?php

        ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                [
                    'attribute' => 'author_id',
                    'format' => 'raw',
                    'value' => function (Ad $model) {
                        if(!isset($model->author)){
                            return null;
                        }
                        return sprintf("%s (id: %s)", $model->author->getFullname(), $model->author_id);
                    },
                ],
                [
                    'attribute' => 'title',
                    'format' => 'raw',
                    'value' => function (Ad $model) {
                        return Html::a($model->title, $model->getLink());
                    },
                ],
                'description:ntext',
                'created_at',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {edit} {delete}',
                    'buttons' => [
                        'view' => function ($url, Ad $model) {
                            $options = [
                                'class' => 'btn-view',
                                'title' => Yii::t('yii', 'View'),
                                'aria-label' => Yii::t('yii', 'View'),
                                'data-pjax' => '0',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', \Yii::$app->urlManager->createUrl(['ad/view', 'id' => $model->id]), $options);
                        },
                        'edit' => function ($url, Ad $model) {
                            if(\Yii::$app->user->isGuest){
                                return null;
                            }
                            $options = [
                                'class' => 'btn-edit',
                                'title' => Yii::t('yii', 'Edit'),
                                'aria-label' => Yii::t('yii', 'Edit'),
                                'data-pjax' => '0',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', \Yii::$app->urlManager->createUrl(['ad/edit', 'id' => $model->id]), $options);
                        },
                        'delete' => function ($url, Ad $model) {
                            if(\Yii::$app->user->isGuest || \Yii::$app->user->id != $model->author_id){
                                return null;
                            }
                            $options = [
                                'class' => 'btn-delete',
                                'title' => Yii::t('yii', 'Delete'),
                                'aria-label' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', \Yii::$app->urlManager->createUrl(['ad/delete', 'id' => $model->id]), $options);
                        }
                    ],
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?></div>

</div>
