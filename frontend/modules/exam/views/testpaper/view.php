<?php

/* @var $this yii\web\View */
/* @var $testpaper array */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '试卷详情';
$this->params['breadcrumbs'][] = ['label' => '试卷库', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/exam.css', ['depends' => 'frontend\assets\AppAsset']);

$periods = [
    '2' => '初中',
    '3' => '高中',
    '4' => '综合',
];

$title = $testpaper['title'] ?? '未命名试卷';
$courseName = $testpaper['course_name'] ?? '未知';
$period = $testpaper['period'] ?? '';
$questions = $testpaper['questions'] ?? [];
$totalScore = $testpaper['total_score'] ?? 0;
$questionCount = count($questions);
?>

<div class="exam-page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-file-alt"></i> 试卷详情</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><?= Html::a('首页', ['/site/index']) ?></li>
                    <li class="breadcrumb-item"><?= Html::a('试卷库', ['index']) ?></li>
                    <li class="breadcrumb-item active"><?= Html::encode(mb_substr($title, 0, 30)) ?></li>
                </ol>
            </nav>
        </div>
        <div>
            <?= Html::a('<i class="fas fa-arrow-left"></i> 返回', ['index'], ['class' => 'btn exam-btn exam-btn-outline']) ?>
        </div>
    </div>
</div>

<div class="container" style="padding-top:20px; max-width:900px;">
    <!-- Paper header -->
    <div class="paper-view-header">
        <h3 style="text-align:center;margin-bottom:16px"><?= Html::encode($title) ?></h3>
        <div style="text-align:center;color:var(--exam-text-secondary);font-size:14px">
            <span class="mr-3"><i class="fas fa-book"></i> <?= Html::encode($courseName) ?></span>
            <?php if ($period): ?>
                <span class="mr-3 period-badge period-<?= $period ?>"><?= $periods[$period] ?? $period ?></span>
            <?php endif; ?>
            <span class="mr-3"><i class="fas fa-list-ol"></i> <?= $questionCount ?> 题</span>
            <span><i class="fas fa-star"></i> 共 <?= $totalScore ?> 分</span>
        </div>
    </div>

    <!-- Questions -->
    <?php if (empty($questions)): ?>
        <div class="exam-empty">
            <div class="empty-icon">📄</div>
            <div class="empty-text">试卷暂未添加试题</div>
            <div class="empty-hint">前往组卷页面添加题目</div>
        </div>
    <?php else: ?>
        <div class="paper-question-list">
            <?php $num = 1; ?>
            <?php foreach ($questions as $q): ?>
                <?php
                    $qData = $q['question'] ?? $q;
                    $qId = $qData['id'] ?? $q['id'] ?? 0;
                    $qContent = $qData['content'] ?? $q['content'] ?? '';
                    $qType = $qData['type_name'] ?? $q['type_name'] ?? '题';
                    $qScore = $q['score'] ?? $qData['score'] ?? 0;
                ?>
                <div class="paper-question-item">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start">
                        <div style="flex:1">
                            <span class="exam-badge exam-badge-primary mb-2"><?= Html::encode($qType) ?></span>
                            <div style="font-size:15px;line-height:1.7;margin-top:4px">
                                <?= nl2br(Html::encode(mb_substr(strip_tags($qContent), 0, 300))) ?>
                            </div>
                        </div>
                        <span style="color:var(--exam-primary);font-weight:600;white-space:nowrap;margin-left:12px">
                            <?= $qScore ?> 分
                        </span>
                    </div>
                </div>
                <?php $num++; ?>
            <?php endforeach; ?>
        </div>

        <!-- Print button -->
        <div style="text-align:center;margin:24px 0">
            <button class="btn exam-btn exam-btn-primary" onclick="window.print()">
                <i class="fas fa-print"></i> 打印试卷
            </button>
        </div>
    <?php endif; ?>
</div>
