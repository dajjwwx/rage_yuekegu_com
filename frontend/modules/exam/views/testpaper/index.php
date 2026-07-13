<?php

/* @var $this yii\web\View */
/* @var $courseId string */
/* @var $period string */
/* @var $keyword string */
/* @var $courses array */
/* @var $papers array */
/* @var $total int */
/* @var $page int */
/* @var $pageCount int */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\LinkPager;

$this->title = '试卷库';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/exam.css', ['depends' => 'frontend\assets\AppAsset']);

$periods = [
    '' => '全部学段',
    '2' => '初中',
    '3' => '高中',
    '4' => '综合',
];
?>

<div class="exam-page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-folder-open"></i> 试卷库</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><?= Html::a('首页', ['/site/index']) ?></li>
                    <li class="breadcrumb-item active">试卷库</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <?= Html::a('<i class="fas fa-search"></i> 试题浏览', ['/exam/question/index'], ['class' => 'btn exam-btn exam-btn-outline']) ?>
        </div>
    </div>
</div>

<div class="container" style="padding-top:20px; max-width:1100px;">
    <!-- Filter bar -->
    <div class="exam-filter-bar">
        <form method="get" class="filter-group">
            <div class="filter-item">
                <span class="filter-label">学段:</span>
                <select name="period" class="form-control form-control-sm" onchange="this.form.submit()">
                    <?php foreach ($periods as $val => $label): ?>
                        <option value="<?= $val ?>" <?= $period == $val ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-item">
                <span class="filter-label">学科:</span>
                <select name="course" class="form-control form-control-sm" onchange="this.form.submit()">
                    <option value="">全部学科</option>
                    <?php foreach ($courses as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= $courseId == $c['id'] ? 'selected' : '' ?>><?= Html::encode($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-item">
                <input type="text" name="keyword" class="form-control form-control-sm" placeholder="搜索试卷标题..." value="<?= Html::encode($keyword) ?>" style="width:180px">
                <button type="submit" class="btn exam-btn-primary btn-sm"><i class="fas fa-search"></i></button>
            </div>
        </form>
    </div>

    <!-- Actions -->
    <div class="d-flex gap-2 mb-3">
        <?= Html::a('<i class="fas fa-plus-circle"></i> 手动组卷', ['create'], ['class' => 'btn exam-btn exam-btn-primary']) ?>
        <?= Html::a('<i class="fas fa-magic"></i> 智能组卷', ['smart'], ['class' => 'btn exam-btn exam-btn-outline']) ?>
    </div>

    <!-- Summary -->
    <div class="exam-summary">
        <div class="result-count">共 <strong><?= $total ?></strong> 份试卷</div>
        <?php if ($pageCount > 1): ?>
            <div class="text-muted" style="font-size:13px">第 <?= $page ?> / <?= $pageCount ?> 页</div>
        <?php endif; ?>
    </div>

    <!-- Paper list -->
    <?php if (empty($papers)): ?>
        <div class="exam-empty">
            <div class="empty-icon">📋</div>
            <div class="empty-text">还没有试卷</div>
            <div class="empty-hint">点击上方按钮创建第一份试卷</div>
        </div>
    <?php else: ?>
        <?php foreach ($papers as $paper): ?>
            <div class="testpaper-card">
                <div class="tp-title">
                    <?= Html::a(Html::encode($paper->title), ['view', 'id' => $paper->id]) ?>
                </div>
                <div class="tp-meta">
                    <?php if ($paper->course_name): ?>
                        <span><i class="fas fa-book"></i> <?= Html::encode($paper->course_name) ?></span>
                    <?php endif; ?>
                    <?php if ($paper->period): ?>
                        <span class="period-badge period-<?= $paper->period ?>">
                            <?= $periods[$paper->period] ?? '学段' . $paper->period ?>
                        </span>
                    <?php endif; ?>
                    <?php if ($paper->question_count ?? false): ?>
                        <span><i class="fas fa-list-ol"></i> <?= $paper->question_count ?> 题</span>
                    <?php endif; ?>
                    <?php if ($paper->total_score ?? false): ?>
                        <span><i class="fas fa-star"></i> <?= $paper->total_score ?> 分</span>
                    <?php endif; ?>
                    <?php if ($paper->created ?? false): ?>
                        <span><i class="far fa-calendar-alt"></i> <?= date('Y-m-d', is_numeric($paper->created) ? $paper->created : strtotime($paper->created)) ?></span>
                    <?php endif; ?>
                </div>
                <div class="tp-actions">
                    <?= Html::a('<i class="far fa-eye"></i> 查看', ['view', 'id' => $paper->id], ['class' => 'btn exam-btn-outline btn-sm']) ?>
                    <?= Html::a('<i class="fas fa-print"></i> 打印', ['print', 'id' => $paper->id], ['class' => 'btn exam-btn-outline btn-sm']) ?>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Pagination -->
        <?php if ($pageCount > 1): ?>
            <div class="exam-pagination">
                <?= LinkPager::widget([
                    'pagination' => new \yii\data\Pagination([
                        'totalCount' => $total,
                        'pageSize' => 20,
                        'page' => $page - 1,
                    ]),
                ]) ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
