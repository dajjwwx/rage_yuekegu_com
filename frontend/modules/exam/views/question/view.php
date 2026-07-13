<?php

/* @var $this yii\web\View */
/* @var $question array */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '试题详情';
$this->params['breadcrumbs'][] = ['label' => '试题浏览', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/exam.css', ['depends' => 'frontend\assets\AppAsset']);

$typeName = $question['type_name'] ?? '未知';
$courseName = $question['course_name'] ?? '未知';

$diffText = '普通';
$diffClass = 'difficulty-normal';
if (isset($question['rate'])) {
    if ($question['rate'] <= 0.3) { $diffText = '容易'; $diffClass = 'difficulty-easy'; }
    elseif ($question['rate'] >= 0.7) { $diffText = '困难'; $diffClass = 'difficulty-hard'; }
}
$diffPercent = isset($question['rate']) ? number_format($question['rate'] * 100, 1) . '%' : '未知';
?>

<div class="exam-page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-file-alt"></i> 试题详情</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><?= Html::a('首页', ['/site/index']) ?></li>
                    <li class="breadcrumb-item"><?= Html::a('试题浏览', ['index']) ?></li>
                    <li class="breadcrumb-item active">#<?= $question['id'] ?></li>
                </ol>
            </nav>
        </div>
        <div>
            <?= Html::a('<i class="fas fa-arrow-left"></i> 返回列表', ['index'], ['class' => 'btn exam-btn exam-btn-outline']) ?>
        </div>
    </div>
</div>

<div class="container" style="padding-top:20px; max-width:900px;">
    <div class="question-detail">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h4 style="margin:0">
                    试题 #<?= $question['id'] ?>
                    <span class="exam-badge exam-badge-primary ml-2"><?= Html::encode($typeName) ?></span>
                    <span class="exam-badge exam-badge-light ml-1"><?= Html::encode($courseName) ?></span>
                </h4>
            </div>
        </div>

        <!-- Content -->
        <div class="q-content-area">
            <?= nl2br(Html::encode($question['content'] ?? '')) ?>
        </div>

        <!-- Options -->
        <?php if (!empty($question['options'])): ?>
            <div class="q-options">
                <h6 style="font-weight:600;color:var(--exam-text-secondary);margin-bottom:10px"><i class="fas fa-list"></i> 选项</h6>
                <?php foreach ($question['options'] as $i => $opt): ?>
                    <div class="option-item">
                        <strong><?= Html::encode($opt['text'] ?? chr(65 + $i)) ?>.</strong>
                        <?php if (!empty($opt['content'])): ?>
                            <?= Html::encode($opt['content']) ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Answer -->
        <?php if (!empty($question['answer'])): ?>
            <?php
                $answer = $question['answer'];
                $answerContent = is_object($answer) ? $answer->content : ($answer['content'] ?? '');
                $answerAnalysis = is_object($answer) ? ($answer->analysis ?? '') : ($answer['analysis'] ?? '');
            ?>
            <div class="q-answer">
                <h6><i class="fas fa-check-circle"></i> 参考答案</h6>
                <div style="font-size:15px"><?= nl2br(Html::encode($answerContent)) ?></div>
                <?php if (!empty($answerAnalysis)): ?>
                    <div class="mt-3">
                        <h6 style="color:var(--exam-text-secondary)"><i class="fas fa-lightbulb"></i> 解析</h6>
                        <div style="font-size:14px;color:var(--exam-text-secondary)">
                            <?= nl2br(Html::encode($answerAnalysis)) ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Meta -->
        <div class="mt-4">
            <h6 style="font-weight:600;color:var(--exam-text-secondary);margin-bottom:10px">
                <i class="fas fa-info-circle"></i> 试题信息
            </h6>
            <table class="table table-sm table-bordered q-meta-table">
                <tr>
                    <th>题型</th>
                    <td><?= Html::encode($typeName) ?></td>
                    <th>学科</th>
                    <td><?= Html::encode($courseName) ?></td>
                </tr>
                <tr>
                    <th>难度</th>
                    <td class="<?= $diffClass ?>"><?= $diffText ?>（错误率 <?= $diffPercent ?>）</td>
                    <th>发布日期</th>
                    <td><?= !empty($question['pubdate']) ? date('Y-m-d', $question['pubdate']) : '未知' ?></td>
                </tr>
                <tr>
                    <th>来源</th>
                    <td colspan="3"><?= Html::encode($question['source'] ?? '未知') ?></td>
                </tr>
                <tr>
                    <th>分类</th>
                    <td colspan="3">
                        <?php if (!empty($question['categories'])): ?>
                            <?php foreach ($question['categories'] as $cat): ?>
                                <span class="exam-badge exam-badge-light mr-1"><?= Html::encode($cat['name']) ?></span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="text-muted">未分类</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
