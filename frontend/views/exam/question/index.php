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

// Register exam CSS
$this->registerCssFile('@web/css/exam.css', ['depends' => 'frontend\assets\AppAsset']);

$periods = [
    '' => '全部学段',
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
?>

<div class="exam-page-header">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>📝 试题浏览</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><?= Html::a('首页', ['/site/index']) ?></li>
                        <li class="breadcrumb-item active">试题浏览</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <!-- Left sidebar: Course/Tree selector -->
        <div class="col-md-3 col-lg-2 exam-sidebar">
            <!-- Period selector -->
            <div class="course-selector">
                <label class="font-weight-bold">学段</label>
                <div class="btn-group btn-group-sm d-flex">
                    <?php foreach ($periods as $val => $label): ?>
                        <?php if ($val === ''): continue; endif; ?>
                        <?= Html::a($label, 
                            Url::current(['xd' => $val === '' ? null : $val, 'page' => null]), 
                            ['class' => 'btn ' . ($period == $val ? 'btn-primary' : 'btn-outline-secondary')]
                        ) ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Course selector -->
            <div class="course-selector">
                <label class="font-weight-bold">学科</label>
                <div class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                    <?php foreach ($courses as $course): ?>
                        <?php
                            $url = Url::current(['chid' => $course['id'], 'xd' => $course['period'] ?? $period, 'page' => null]);
                            $active = $courseId == $course['id'];
                        ?>
                        <?= Html::a(
                            Html::encode($course['name']),
                            $url,
                            ['class' => 'list-group-item list-group-item-action py-1 ' . ($active ? 'active' : '')]
                        ) ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <hr>

            <!-- Tree type toggle -->
            <div class="tree-toggle">
                <label class="font-weight-bold">分类方式</label>
                <div class="btn-group btn-group-sm d-flex">
                    <?= Html::a('📖 章节', Url::current(['tree_type' => 'category', 'page' => null]), [
                        'class' => 'btn ' . ($treeType === 'category' ? 'btn-primary' : 'btn-outline-secondary')
                    ]) ?>
                    <?= Html::a('🎯 知识点', Url::current(['tree_type' => 'knowledge', 'page' => null]), [
                        'class' => 'btn ' . ($treeType === 'knowledge' ? 'btn-primary' : 'btn-outline-secondary')
                    ]) ?>
                </div>
            </div>

            <!-- Category Tree -->
            <div class="mt-2">
                <label class="font-weight-bold"><?= $treeType === 'knowledge' ? '知识点' : '章节' ?>树</label>
                <div class="tree-view-container" style="max-height: calc(100vh - 500px); overflow-y: auto;">
                    <?= $this->render('_tree', ['categories' => $categoryTree, 'activeId' => $categoryId, 'depth' => 0]) ?>
                </div>
            </div>
        </div>

        <!-- Main content: filters + question list -->
        <div class="col-md-9 col-lg-10">
            <!-- Filter bar -->
            <div class="filter-bar">
                <div class="row">
                    <div class="col">
                        <form method="get" class="form-inline flex-wrap" id="filter-form">
                            <input type="hidden" name="tree_type" value="<?= Html::encode($treeType) ?>">
                            <input type="hidden" name="xd" value="<?= Html::encode($period) ?>">
                            <input type="hidden" name="chid" value="<?= Html::encode($courseId) ?>">
                            <input type="hidden" name="category_id" value="<?= Html::encode($categoryId) ?>">

                            <div class="filter-item">
                                <span class="filter-label">题型:</span>
                                <select name="type" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">全部</option>
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
                                    <option value="">全部</option>
                                    <?php foreach ($years as $y): ?>
                                        <option value="<?= $y ?>" <?= $year == $y ? 'selected' : '' ?>><?= $y ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="filter-item">
                                <span class="filter-label">来源:</span>
                                <select name="source" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">全部</option>
                                    <?php foreach ($sources as $s): ?>
                                        <?php $shortSource = mb_substr($s, 0, 20); ?>
                                        <option value="<?= Html::encode($s) ?>" <?= $source == $s ? 'selected' : '' ?>><?= Html::encode($shortSource) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="filter-item">
                                <input type="text" name="keyword" class="form-control form-control-sm" placeholder="搜索试题内容..." value="<?= Html::encode($keyword) ?>" style="width:180px">
                                <button type="submit" class="btn btn-sm btn-outline-primary ml-1">搜索</button>
                                <?php if ($keyword): ?>
                                    <?= Html::a('清除', Url::current(['keyword' => null]), ['class' => 'btn btn-sm btn-outline-secondary ml-1']) ?>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Results summary -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <strong>共 <?= $total ?> 道试题</strong>
                    <?php if (!empty($courseId)): ?>
                        <?php foreach ($courses as $c): ?>
                            <?php if ($c['id'] == $courseId): ?>
                                <span class="ml-2 badge badge-info"><?= Html::encode($c['name']) ?></span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if (!empty($typeId)): ?>
                        <?php foreach ($types as $t): ?>
                            <?php if ($t['id'] == $typeId): ?>
                                <span class="badge badge-secondary"><?= Html::encode($t['name']) ?></span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div>
                    <?php if ($pageCount > 1): ?>
                        <small class="text-muted">第 <?= $page ?> / <?= $pageCount ?> 页</small>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Question list -->
            <?php if (empty($questions)): ?>
                <div class="alert alert-info">
                    没有找到匹配的试题，请调整筛选条件。
                </div>
            <?php else: ?>
                <?php foreach ($questions as $question): ?>
                    <div class="question-list-item">
                        <div class="q-header">
                            <?php
                                $typeName = '';
                                foreach ($types as $t) {
                                    if ($t['id'] == $question->type) { $typeName = $t['name']; break; }
                                }
                            ?>
                            <?php if ($typeName): ?>
                                <span class="badge badge-primary q-badge"><?= Html::encode($typeName) ?></span>
                            <?php endif; ?>
                            <?php
                                $diffText = '普通';
                                $diffClass = 'difficulty-normal';
                                if ($question->rate <= 0.3) { $diffText = '容易'; $diffClass = 'difficulty-easy'; }
                                elseif ($question->rate >= 0.7) { $diffText = '困难'; $diffClass = 'difficulty-hard'; }
                                $diffPercent = number_format($question->rate * 100, 1) . '%';
                            ?>
                            <span class="q-badge <?= $diffClass ?>"><?= $diffText ?> (<?= $diffPercent ?>)</span>
                            <?php if ($question->source): ?>
                                <span class="badge badge-light q-badge"><?= Html::encode(mb_substr($question->source, 0, 30)) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="q-content">
                            <?= Html::a(
                                mb_substr(strip_tags($question->content), 0, 200),
                                ['view', 'id' => $question->id],
                                ['style' => 'color:inherit; text-decoration:none;']
                            ) ?>
                        </div>
                        <div class="q-meta">
                            <?php if ($question->pubdate): ?>
                                <span>📅 <?= date('Y-m-d', $question->pubdate) ?></span>
                            <?php endif; ?>
                            <span class="ml-3">📊 得分率: <?= $diffPercent ?></span>
                        </div>
                        <div class="q-actions">
                            <?= Html::a('查看详情', ['view', 'id' => $question->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- Pagination -->
                <?php if ($pageCount > 1): ?>
                    <div class="mt-3">
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
</div>

<?php
// Ensure the filter form submits with current tree_type/xd/chid/category_id intact
$js = <<<JS
// Add active state to category links
$('.tree-view a').on('click', function(e) {
    // Let the link naturally navigate - our backend handles the category_id param
});
JS;
$this->registerJs($js);
?>
