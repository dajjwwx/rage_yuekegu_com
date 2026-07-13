<?php

/* @var $this yii\web\View */
/* @var $courses array */
/* @var $types array */
/* @var $papers array|null */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '智能组卷';
$this->params['breadcrumbs'][] = ['label' => '试卷库', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/exam.css', ['depends' => 'frontend\assets\AppAsset']);
?>

<div class="exam-page-header">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>🤖 智能组卷</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><?= Html::a('首页', ['/site/index']) ?></li>
                        <li class="breadcrumb-item"><?= Html::a('试卷库', ['index']) ?></li>
                        <li class="breadcrumb-item active">智能组卷</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="smart-paper-form">
        <h4 class="mb-4">按条件自动生成试卷</h4>

        <?php $form = \yii\bootstrap4\ActiveForm::begin([
            'method' => 'post',
            'options' => ['class' => ''],
        ]); ?>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="font-weight-bold">学科</label>
                    <select name="course" class="form-control">
                        <option value="">请选择学科</option>
                        <?php foreach ($courses as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= Html::encode($c['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="font-weight-bold">学段</label>
                    <select name="period" class="form-control">
                        <option value="">请选择学段</option>
                        <option value="2">初中</option>
                        <option value="3">高中</option>
                        <option value="4">综合</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="font-weight-bold">题型</label>
                    <select name="type" class="form-control">
                        <option value="">全部题型</option>
                        <?php foreach ($types as $t): ?>
                            <option value="<?= $t['id'] ?>"><?= Html::encode($t['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="font-weight-bold">难度</label>
                    <select name="difficulty" class="form-control">
                        <option value="">全部难度</option>
                        <option value="easy">容易</option>
                        <option value="normal">普通</option>
                        <option value="hard">困难</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="font-weight-bold">题目数量</label>
                    <select name="count" class="form-control">
                        <option value="5">5 题</option>
                        <option value="10" selected>10 题</option>
                        <option value="15">15 题</option>
                        <option value="20">20 题</option>
                        <option value="30">30 题</option>
                    </select>
                </div>
            </div>
        </div>

        <?= Html::submitButton('🤖 智能生成', ['class' => 'btn btn-info btn-block']) ?>

        <?php \yii\bootstrap4\ActiveForm::end(); ?>

        <!-- Results -->
        <?php if ($papers !== null): ?>
            <div class="mt-4">
                <h5>生成的题目（共 <?= count($papers['items'] ?? []) ?> 题）</h5>

                <?php if (empty($papers['items'])): ?>
                    <div class="alert alert-warning">未找到匹配的题目，请调整条件。</div>
                <?php else: ?>
                    <div class="list-group">
                        <?php foreach ($papers['items'] as $q): ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span class="badge badge-primary"><?= Html::encode($q->type) ?></span>
                                        <span class="ml-2"><?= Html::encode(mb_substr(strip_tags($q->content), 0, 150)) ?></span>
                                    </div>
                                    <div>
                                        <?= Html::a('查看', ['/exam/question/view', 'id' => $q->id], [
                                            'class' => 'btn btn-sm btn-outline-primary',
                                            'target' => '_blank',
                                        ]) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-3">
                        <?= Html::a('📋 保存为试卷', ['create'], ['class' => 'btn btn-success']) ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
