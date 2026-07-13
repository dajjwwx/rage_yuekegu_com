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
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>📋 试卷库</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><?= Html::a('首页', ['/site/index']) ?></li>
                        <li class="breadcrumb-item active">试卷库</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Filter bar -->
    <div class="filter-bar">
        <form method="get" class="form-inline">
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
                <input type="text" name="keyword" class="form-control form-control-sm" placeholder="搜索试卷标题..." value="<?= Html::encode($keyword) ?>" style="width:200px">
                <button type="submit" class="btn btn-sm btn-outline-primary ml-1">搜索</button>
            </div>
        </form>
    </div>

    <!-- Action buttons -->
    <div class="mb-3">
        <?= Html::a('➕ 手动组卷', ['create'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('🤖 智能组卷', ['smart'], ['class' => 'btn btn-info']) ?>
    </div>

    <!-- Summary -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <strong>共 <?= $total ?> 份试卷</strong>
        <?php if ($pageCount > 1): ?>
            <small class="text-muted">第 <?= $page ?> / <?= $pageCount ?> 页</small>
        <?php endif; ?>
    </div>

    <!-- Paper list -->
    <?php if (empty($papers)): ?>
        <div class="alert alert-info">暂无试卷。</div>
    <?php else: ?>
        <?php foreach ($papers as $paper): ?>
            <div class="paper-list-item">
                <div class="paper-title">
                    <?= Html::a(Html::encode($paper->title), ['view', 'id' => $paper->id]) ?>
                </div>
                <div class="paper-meta">
                    <?php if ($paper->course): ?>
                        <?php 
                            $courseName = '';
                            foreach ($courses as $c) {
                                if ($c['id'] == $paper->course) { $courseName = $c['name']; break; }
                            }
                        ?>
                        <span>📚 <?= Html::encode($courseName) ?></span>
                    <?php endif; ?>
                    <?php if ($paper->period): ?>
                        <span class="ml-3 period-badge period-<?= $paper->period ?>">
                            <?= $periods[$paper->period] ?? '学段' . $paper->period ?>
                        </span>
                    <?php endif; ?>
                    <?php if ($paper->created): ?>
                        <span class="ml-3">📅 <?= date('Y-m-d', $paper->created) ?></span>
                    <?php endif; ?>
                </div>
                <div class="mt-2">
                    <?= Html::a('查看详情', ['view', 'id' => $paper->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Pagination -->
        <?php if ($pageCount > 1): ?>
            <div class="mt-3">
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
