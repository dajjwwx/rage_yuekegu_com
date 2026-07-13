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
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>📝 试题详情</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><?= Html::a('首页', ['/site/index']) ?></li>
                        <li class="breadcrumb-item"><?= Html::a('试题浏览', ['index']) ?></li>
                        <li class="breadcrumb-item active">试题 #<?= $question['id'] ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="question-detail">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h4>
                    试题 #<?= $question['id'] ?>
                    <span class="badge badge-primary q-type-badge ml-2"><?= Html::encode($typeName) ?></span>
                    <span class="badge badge-info ml-1"><?= Html::encode($courseName) ?></span>
                </h4>
            </div>
            <div>
                <?= Html::a('← 返回列表', ['index'], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
            </div>
        </div>

        <!-- Content -->
        <div class="q-content-area">
            <?= nl2br(Html::encode($question['content'] ?? '')) ?>
        </div>

        <!-- Options (for objective questions) -->
        <?php if (!empty($question['options'])): ?>
            <div class="q-options">
                <h6>选项：</h6>
                <?php foreach ($question['options'] as $opt): ?>
                    <div class="option-item">
                        <strong><?= Html::encode($opt['text'] ?? '') ?></strong>
                        <?php if (!empty($opt['content'])): ?>
                            : <?= Html::encode($opt['content']) ?>
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
                <h6>答案：</h6>
                <div><?= nl2br(Html::encode($answerContent)) ?></div>
                <?php if (!empty($answerAnalysis)): ?>
                    <div class="mt-2">
                        <h6>解析：</h6>
                        <div><?= nl2br(Html::encode($answerAnalysis)) ?></div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Meta info -->
        <div class="mt-4">
            <h6>试题信息</h6>
            <table class="table table-sm table-bordered q-meta-table">
                <tr>
                    <th>题型</th>
                    <td><?= Html::encode($typeName) ?></td>
                    <th>学科</th>
                    <td><?= Html::encode($courseName) ?></td>
                </tr>
                <tr>
                    <th>难度</th>
                    <td class="<?= $diffClass ?>"><?= $diffText ?> (错误率 <?= $diffPercent ?>)</td>
                    <th>发布日</th>
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
                                <span class="badge badge-light"><?= Html::encode($cat['name']) ?></span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            未分类
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
