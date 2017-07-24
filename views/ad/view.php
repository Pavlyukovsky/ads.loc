<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Ad;

/* @var $this yii\web\View */
/* @var $model app\models\Ad */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ad-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if(!\Yii::$app->user->isGuest):?>
        <p>
            <?= Html::a('Update', \Yii::$app->urlManager->createUrl(['ad/edit', 'id' => $model->id]), ['class' => 'btn btn-primary']) ?>
            <?php if (\Yii::$app->user->id == $model->author_id): ?>
            <?= Html::a('Delete', \Yii::$app->urlManager->createUrl(['ad/delete', 'id' => $model->id]), [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
            <?php endif;?>
        </p>
    <?php endif;?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
            'title',
            'description:ntext',
            'created_at',
        ],
    ]) ?>

</div>
