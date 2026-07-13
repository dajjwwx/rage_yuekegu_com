<?php

use common\helpers\Html;

$this->title = '创建试卷';
$this->params['breadcrumbs'][] = ['label' => '试卷管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $this->title; ?></h3>
            </div>
            <?= $this->render('_form', [
                'model' => $model,
                'courses' => $courses,
            ]) ?>
        </div>
    </div>
</div>
