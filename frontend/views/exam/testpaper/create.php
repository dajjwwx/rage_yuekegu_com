<?php

/* @var $this yii\web\View */
/* @var $courses array */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '手动组卷';
$this->params['breadcrumbs'][] = ['label' => '试卷库', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/exam.css', ['depends' => 'frontend\assets\AppAsset']);
?>

<div class="exam-page-header">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>📋 手动组卷</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><?= Html::a('首页', ['/site/index']) ?></li>
                        <li class="breadcrumb-item"><?= Html::a('试卷库', ['index']) ?></li>
                        <li class="breadcrumb-item active">手动组卷</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="create-paper-form">
        <h4 class="mb-4">创建新试卷</h4>

        <?php $form = \yii\bootstrap4\ActiveForm::begin([
            'method' => 'post',
            'options' => ['class' => ''],
        ]); ?>

        <div class="form-group">
            <label class="font-weight-bold">试卷标题</label>
            <input type="text" name="title" class="form-control" placeholder="请输入试卷标题" required>
        </div>

        <div class="form-group">
            <label class="font-weight-bold">学科</label>
            <select name="course" class="form-control">
                <option value="">请选择学科</option>
                <?php foreach ($courses as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= Html::encode($c['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="font-weight-bold">学段</label>
            <select name="period" class="form-control">
                <option value="">请选择学段</option>
                <option value="2">初中</option>
                <option value="3">高中</option>
                <option value="4">综合</option>
            </select>
        </div>

        <div class="form-group">
            <label class="font-weight-bold">年级</label>
            <select name="grade" class="form-control">
                <option value="">请选择年级</option>
                <option value="7">七年级</option>
                <option value="8">八年级</option>
                <option value="9">九年级</option>
                <option value="10">高一</option>
                <option value="11">高二</option>
                <option value="12">高三</option>
            </select>
        </div>

        <div class="form-group">
            <label class="font-weight-bold">试卷说明</label>
            <textarea name="content" class="form-control" rows="4" placeholder="试卷说明文字（可选）"></textarea>
        </div>

        <?= Html::submitButton('创建试卷', ['class' => 'btn btn-primary btn-block']) ?>

        <?php \yii\bootstrap4\ActiveForm::end(); ?>

        <div class="mt-3">
            <div class="alert alert-info">
                <strong>提示：</strong>
                创建试卷后，您可以在试题浏览页面勾选题目添加到试卷中。
                或者使用 <a href="<?= Url::to(['smart']) ?>">智能组卷</a> 功能自动生成试卷。
            </div>
        </div>
    </div>
</div>
