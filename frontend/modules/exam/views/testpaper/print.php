<?php

/* @var $this yii\web\View */
/* @var $testpaper array */

use yii\helpers\Html;

$title = $testpaper['title'] ?? '未命名试卷';
$courseName = $testpaper['course_name'] ?? '';
$questions = $testpaper['questions'] ?? [];
$totalScore = $testpaper['total_score'] ?? 0;

$periods = ['2' => '小学', '3' => '初中', '4' => '高中'];
$period = $testpaper['period'] ?? '';

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title><?= Html::encode($title) ?> - 打印版</title>
    <style>
        @page { margin: 2cm; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: "SimSun", "宋体", serif; font-size: 14px; line-height: 1.8; color: #000; padding: 20px; }
        .paper-title { text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 6px; }
        .paper-sub { text-align: center; font-size: 14px; color: #555; margin-bottom: 20px; }
        .paper-info { text-align: center; font-size: 13px; color: #666; margin-bottom: 24px; border-bottom: 1px solid #000; padding-bottom: 10px; }
        .question-item { margin-bottom: 18px; padding: 8px 0; border-bottom: 1px dashed #ddd; }
        .question-num { font-weight: bold; margin-right: 6px; }
        .question-content { margin-bottom: 6px; }
        .question-score { float: right; color: #666; font-size: 13px; }
        .question-answer { margin-top: 4px; font-size: 13px; color: #999; }
        .answer-section { margin-top: 30px; border-top: 2px solid #000; padding-top: 16px; }
        .answer-section h3 { text-align: center; margin-bottom: 12px; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
        .no-print { text-align: center; margin-bottom: 20px; }
        .no-print button { padding: 8px 24px; font-size: 16px; cursor: pointer; background: #1a73e8; color: #fff; border: none; border-radius: 6px; }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()">🖨️ 打印此试卷</button>
    </div>

    <div class="paper-title"><?= Html::encode($title) ?></div>
    <div class="paper-sub"><?= Html::encode($courseName) ?> <?php if ($period) echo '· ' . ($periods[$period] ?? '') ?></div>
    <div class="paper-info">
        <span>总分：<?= $totalScore ?> 分</span>
        <span style="margin-left:20px">题数：<?= count($questions) ?> 题</span>
    </div>

    <?php if (empty($questions)): ?>
        <p style="text-align:center;color:#999;margin-top:40px">本试卷暂无题目</p>
    <?php else: ?>
        <?php $num = 1; ?>
        <?php foreach ($questions as $q): ?>
            <?php
                $qData = $q['question'] ?? $q;
                $qContent = strip_tags($qData['content'] ?? $q['content'] ?? '');
                $qType = $qData['type_name'] ?? $q['type_name'] ?? '题';
                $qScore = $q['score'] ?? 0;
                $qAnswer = strip_tags($qData['answer']['content'] ?? $q['answer']['content'] ?? '');
            ?>
            <div class="question-item">
                <div>
                    <span class="question-num"><?= $num ?>.</span>
                    <span class="question-score">[<?= $qType ?>] <?= $qScore ?>分</span>
                </div>
                <div class="question-content"><?= nl2br(Html::encode($qContent)) ?></div>
            </div>
            <?php $num++; ?>
        <?php endforeach; ?>

        <div class="answer-section">
            <h3>参考答案</h3>
            <?php $num = 1; foreach ($questions as $q): ?>
                <?php
                    $qData = $q['question'] ?? $q;
                    $qAnswer = strip_tags($qData['answer']['content'] ?? $q['answer']['content'] ?? '');
                    $qAnalysis = strip_tags($qData['answer']['analysis'] ?? $q['answer']['analysis'] ?? '');
                ?>
                <div style="margin-bottom:10px">
                    <strong><?= $num ?>.</strong>
                    <?= $qAnswer ? Html::encode($qAnswer) : '略' ?>
                    <?php if ($qAnalysis): ?>
                        <div style="font-size:12px;color:#888;margin-top:2px">解析：<?= Html::encode(mb_substr($qAnalysis, 0, 200)) ?></div>
                    <?php endif; ?>
                </div>
            <?php $num++; endforeach; ?>
        </div>
    <?php endif; ?>
</body>
</html>
