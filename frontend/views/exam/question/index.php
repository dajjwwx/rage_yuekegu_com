<?php

/* @var $this yii\web\View */
/* @var $period string */
/* @var $courseId string */
/* @var $treeType string */
/* @var $typeId string */
/* @var $difficulty string */
/* @var $year string */
/* @var $source string */
/* @var $keyword string */
/* @var $categoryId string */
/* @var $categoryTree array */
/* @var $courses array */
/* @var $types array */
/* @var $years array */
/* @var $sources array */
/* @var $questions array */
/* @var $total int */
/* @var $page int */
/* @var $pageSize int */
/* @var $pageCount int */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\LinkPager;

$this->title = '试题浏览';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/exam.css', ['depends' => 'frontend\assets\AppAsset']);

$periods = [
    '' => '全部',
    '2' => '初中',
    '3' => '高中',
    '4' => '综合',
];
$difficulties = [
    '' => '全部难度',
    'easy' => '容易',
    'normal' => '普通',
    'hard' => '困难',
];

// Mobile sidebar toggle JS
$this->registerJs(<<<JS
$('#sidebar-toggle-btn').on('click', function() {
    $('.exam-sidebar').toggleClass('mobile-show');
    $('.sidebar-overlay').toggleClass('show');
});
$('.sidebar-overlay').on('click', function() {
    $('.exam-sidebar').removeClass('mobile-show');
    $('.sidebar-overlay').removeClass('show');
});
JS
);
?>

<div class="exam-page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-search"></i> 试题浏览</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><?= Html::a('首页', ['/site/index']) ?></li>
                    <li class="breadcrumb-item active">试题浏览</li>
                </ol>
            </nav>
        </div>
        <div>
            <?= Html::a('<i class="fas fa-file-alt"></i> 试卷库', ['/exam/testpaper/index'], ['class' => 'btn exam-btn exam-btn-outline']) ?>
        </div>
    </div>
</div>

<div class="exam-layout">
    <!-- Mobile overlay -->
    <div class="sidebar-overlay"></div>

    <!-- Sidebar -->
    <div class="exam-sidebar">
        <!-- Period -->
        <div class="sidebar-section">
            <div class="sidebar-title">学段</div>
            <div class="period-buttons">
                <?php foreach ($periods as $val => $label): ?>
                    <?= Html::a($label,
                        Url::current(['xd' => $val ?: null, 'page' => null]),
                        ['class' => 'btn ' . ($period == $val ? 'btn-primary' : 'btn-outline-secondary')]
                    ) ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Course -->
        <?php if (!empty($courses)): ?>
        <div class="sidebar-section">
            <div class="sidebar-title">学科</div>
            <div class="course-list">
                <?php foreach ($courses as $course): ?>
                    <?php
                        $url = Url::current(['chid' => $course['id'], 'xd' => $course['period'] ?? $period, 'page' => null]);
                        $active = $courseId == $course['id'];
                    ?>
                    <?= Html::a(
                        Html::encode($course['name']),
                        $url,
                        ['class' => 'course-item ' . ($active ? 'active' : '')]
                    ) ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <hr class="my-2">

        <!-- Tree type toggle -->
        <div class="sidebar-section">
            <div class="sidebar-title">分类方式</div>
            <div class="d-flex gap-1">
                <?= Html::a('📖 章节', Url::current(['tree_type' => 'category', 'page' => null]), [
                    'class' => 'btn btn-sm flex-fill ' . ($treeType === 'category' ? 'btn-primary' : 'btn-outline-secondary')
                ]) ?>
                <?= Html::a('🎯 知识点', Url::current(['tree_type' => 'knowledge', 'page' => null]), [
                    'class' => 'btn btn-sm flex-fill ' . ($treeType === 'knowledge' ? 'btn-primary' : 'btn-outline-secondary')
                ]) ?>
            </div>
        </div>

        <!-- Category Tree -->
        <?php if (!empty($categoryTree)): ?>
        <div class="sidebar-section">
            <div class="sidebar-title"><?= $treeType === 'knowledge' ? '知识点' : '章节' ?>树</div>
            <div class="tree-view-container">
                <?= $this->render('_tree', ['categories' => $categoryTree, 'activeId' => $categoryId, 'depth' => 0]) ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Main -->
    <div class="exam-main">
        <!-- Filter bar -->
        <div class="exam-filter-bar">
            <form method="get" id="filter-form">
                <input type="hidden" name="tree_type" value="<?= Html::encode($treeType) ?>">
                <input type="hidden" name="xd" value="<?= Html::encode($period) ?>">
                <input type="hidden" name="chid" value="<?= Html::encode($courseId) ?>">
                <input type="hidden" name="category_id" value="<?= Html::encode($categoryId) ?>">

                <div class="filter-group">
                    <div class="filter-item">
                        <span class="filter-label">题型:</span>
                        <select name="type" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="">全部题</option>
                            <?php foreach ($types as $t): ?>
                                <option value="<?= $t['id'] ?>" <?= $typeId == $t['id'] ? 'selected' : '' ?>><?= Html::encode($t['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-item">
                        <span class="filter-label">难度:</span>
                        <select name="difficulty" class="form-control form-control-sm" onchange="this.form.submit()">
                            <?php foreach ($difficulties as $val => $label): ?>
                                <option value="<?= $val ?>" <?= $difficulty == $val ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-item">
                        <span class="filter-label">年份:</span>
                        <select name="year" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="">不限</option>
                            <?php foreach ($years as $y): ?>
                                <option value="<?= $y ?>" <?= $year == $y ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-item">
                        <span class="filter-label">来源:</span>
                        <select name="source" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="">不限</option>
                            <?php foreach ($sources as $s): ?>
                                <option value="<?= Html::encode($s) ?>" <?= $source == $s ? 'selected' : '' ?>><?= Html::encode(mb_substr($s, 0, 20)) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-item ml-auto">
                        <input type="text" name="keyword" class="form-control form-control-sm" placeholder="搜试题内容..." value="<?= Html::encode($keyword) ?>" style="width:160px">
                        <button type="submit" class="btn exam-btn-primary btn-sm ml-1"><i class="fas fa-search"></i></button>
                        <?php if ($keyword): ?>
                            <?= Html::a('✕', Url::current(['keyword' => null]), ['class' => 'btn btn-sm btn-outline-secondary ml-1']) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>

        <!-- Summary -->
        <div class="exam-summary">
            <div class="result-count">
                共 <strong><?= $total ?></strong> 道试题
                <?php if (!empty($courseId)): ?>
                    <?php foreach ($courses as $c): ?>
                        <?php if ($c['id'] == $courseId): ?>
                            <span class="exam-badge exam-badge-primary ml-2"><?= Html::encode($c['name']) ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if (!empty($typeId)): ?>
                    <?php foreach ($types as $t): ?>
                        <?php if ($t['id'] == $typeId): ?>
                            <span class="exam-badge exam-badge-light ml-1"><?= Html::encode($t['name']) ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if (!empty($keyword)): ?>
                    <span class="exam-badge exam-badge-warning ml-1">搜索: <?= Html::encode($keyword) ?></span>
                <?php endif; ?>
            </div>
            <?php if ($pageCount > 1): ?>
                <div class="text-muted" style="font-size:13px">第 <?= $page ?> / <?= $pageCount ?> 页</div>
            <?php endif; ?>
        </div>

        <!-- Question List -->
        <?php if (empty($questions)): ?>
            <div class="exam-empty">
                <div class="empty-icon">🔍</div>
                <div class="empty-text">没有找到匹配的试题</div>
                <div class="empty-hint">试试调整筛选条件或换个关键词</div>
            </div>
        <?php else: ?>
            <?php foreach ($questions as $question): ?>
                <div class="question-card">
                    <div class="q-header">
                        <?php
                            $typeName = '';
                            foreach ($types as $t) {
                                if ($t['id'] == $question->type) { $typeName = $t['name']; break; }
                            }
                        ?>
                        <?php if ($typeName): ?>
                            <span class="exam-badge exam-badge-primary"><?= Html::encode($typeName) ?></span>
                        <?php endif; ?>
                        <?php
                            $diffText = '普通';
                            $diffClass = 'difficulty-normal';
                            if ($question->rate <= 0.3) { $diffText = '容易'; $diffClass = 'difficulty-easy'; }
                            elseif ($question->rate >= 0.7) { $diffText = '困难'; $diffClass = 'difficulty-hard'; }
                            $diffPercent = number_format($question->rate * 100, 1) . '%';
                        ?>
                        <span class="exam-badge <?= $diffClass ?>"><?= $diffText ?> (<?= $diffPercent ?>)</span>
                        <?php if ($question->source): ?>
                            <span class="exam-badge exam-badge-light"><?= Html::encode(mb_substr($question->source, 0, 28)) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="q-content">
                        <?= Html::a(
                            mb_substr(strip_tags($question->content), 0, 200),
                            ['view', 'id' => $question->id],
                        ) ?>
                    </div>
                    <div class="q-meta">
                        <?php if ($question->pubdate): ?>
                            <span><i class="far fa-calendar-alt"></i> <?= date('Y-m-d', $question->pubdate) ?></span>
                        <?php endif; ?>
                        <span><i class="fas fa-chart-line"></i> 得分率 <?= $diffPercent ?></span>
                    </div>
                    <div class="q-actions">
                        <?= Html::a('<i class="far fa-eye"></i> 查看详情', ['view', 'id' => $question->id], ['class' => 'btn exam-btn-outline btn-sm']) ?>
                        <button class="btn exam-btn-outline btn-sm select-question" data-id="<?= $question->id ?>">
                            <i class="far fa-check-circle"></i> 选题
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Pagination -->
            <?php if ($pageCount > 1): ?>
                <div class="exam-pagination">
                    <?= LinkPager::widget([
                        'pagination' => new \yii\data\Pagination([
                            'totalCount' => $total,
                            'pageSize' => $pageSize,
                            'page' => $page - 1,
                        ]),
                    ]) ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Mobile sidebar toggle button -->
<button id="sidebar-toggle-btn" class="sidebar-toggle-btn">
    <i class="fas fa-filter"></i>
</button>
