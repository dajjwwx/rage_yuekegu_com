<?php

/* @var $this yii\web\View */
/* @var $testpaper array */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '试卷详情 - ' . $testpaper['title'];
$this->params['breadcrumbs'][] = ['label' => '试卷库', 'url' => ['index']];
$this->params['breadcrumbs'][] = Html::encode($testpaper['title']);

$this->registerCssFile('@web/css/exam.css', ['depends' => 'frontend\assets\AppAsset']);
?>

<div class="exam-page-header">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>📋 试卷详情</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><?= Html::a('首页', ['/site/index']) ?></li>
                        <li class="breadcrumb-item"><?= Html::a('试卷库', ['index']) ?></li>
                        <li class="breadcrumb-item active"><?= Html::encode($testpaper['title']) ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Paper header -->
    <div class="paper-detail-header">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h3><?= Html::encode($testpaper['title']) ?></h3>
                <p class="text-muted mb-0">
                    <?php if (!empty($testpaper['course_name'])): ?>
                        <span>📚 <?= Html::encode($testpaper['course_name']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($testpaper['created'])): ?>
                        <span class="ml-3">📅 <?= date('Y-m-d H:i', $testpaper['created']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($testpaper['type'])): ?>
                        <span class="ml-3">📄 类型: <?= $testpaper['type'] == 3 ? '普通试卷' : '类型' . $testpaper['type'] ?></span>
                    <?php endif; ?>
                </p>
            </div>
            <div>
                <?= Html::a('← 返回列表', ['index'], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
            </div>
        </div>
        <?php if (!empty($testpaper['content'])): ?>
            <div class="mt-3 p-3 bg-light rounded">
                <?= nl2br(Html::encode($testpaper['content'])) ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Questions list -->
    <h4>题目列表 (共 <?= count($testpaper['questions'] ?? []) ?> 题)</h4>

    <?php if (empty($testpaper['questions'])): ?>
        <div class="alert alert-warning">该试卷暂未添加题目。</div>
    <?php else: ?>
        <?php foreach ($testpaper['questions'] as $index => $item): ?>
            <div class="paper-question-item">
                <div class="d-flex justify-content-between">
                    <div>
                        <strong>第 <?= $item['question_num'] ?? ($index + 1) ?> 题</strong>
                        <span class="badge badge-primary ml-2">
                            <?= Html::encode($item['question_type'] ?? '未知题型') ?>
                        </span>
                        <span class="badge badge-success ml-1">
                            <?= (int)($item['score'] ?? 0) ?> 分
                        </span>
                    </div>
                    <?php if (!empty($item['question_id'])): ?>
                        <div>
                            <?= Html::a('查看试题', ['/exam/question/view', 'id' => $item['question_id']], [
                                'class' => 'btn btn-sm btn-outline-primary',
                                'target' => '_blank',
                            ]) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($item['question_content'])): ?>
                    <div class="mt-2">
                        <?= Html::encode(mb_substr(strip_tags($item['question_content']), 0, 300)) ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
