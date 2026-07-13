<?php

/* @var $this yii\web\View */
/* @var $courses array */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '手动组卷';
$this->params['breadcrumbs'][] = ['label' => '试卷库', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/exam.css', ['depends' => 'frontend\assets\AppAsset']);
?>

<div class="exam-page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-plus-circle"></i> 手动组卷</h1>
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

<div class="container" style="padding-top:20px; max-width:700px;">
    <div class="exam-form-section">
        <div class="section-title"><i class="fas fa-info-circle"></i> 试卷基本信息</div>

        <?php $form = ActiveForm::begin(['options' => ['class' => 'smart-paper-form']]); ?>

        <div class="form-group">
            <label>试卷标题 <span class="text-danger">*</span></label>
            <?= Html::textInput('title', '', ['class' => 'form-control', 'placeholder' => '输入试卷标题，如：2024年高一期中考试数学试卷', 'required' => true]) ?>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>学段</label>
                <?= Html::dropDownList('period', '', [
                    '' => '请选择',
                    '2' => '小学',
                    '3' => '初中',
                    '4' => '高中',
                ], ['class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <label>学科 <span class="text-danger">*</span></label>
                <?= Html::dropDownList('course', '', array_merge(['' => '请选择'], \yii\helpers\ArrayHelper::map($courses, 'id', 'name')), ['class' => 'form-control', 'required' => true]) ?>
            </div>
            <div class="form-group">
                <label>总分</label>
                <?= Html::numberInput('total_score', 100, ['class' => 'form-control', 'min' => 1, 'placeholder' => '如：100']) ?>
            </div>
        </div>

        <div class="form-group">
            <label>说明</label>
            <?= Html::textarea('description', '', ['class' => 'form-control', 'rows' => 3, 'placeholder' => '试卷说明（选填）']) ?>
        </div>

        <div class="form-group mt-3" style="text-align:center">
            <button type="submit" class="btn exam-btn exam-btn-primary" style="min-width:200px">
                <i class="fas fa-save"></i> 创建试卷
            </button>
            <?= Html::a('取消', ['index'], ['class' => 'btn exam-btn exam-btn-outline ml-2']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <div class="exam-empty">
        <div class="empty-icon">💡</div>
        <div class="empty-text" style="font-size:14px">创建试卷后，可以在试卷详情页从题库中选题添加</div>
    </div>
</div>
