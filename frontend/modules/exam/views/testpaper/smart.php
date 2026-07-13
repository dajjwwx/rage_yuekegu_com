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

$periods = [
    '' => '不限',
    '2' => '初中',
    '3' => '高中',
    '4' => '综合',
];
$difficulties = [
    '' => '不限',
    'easy' => '容易',
    'normal' => '普通',
    'hard' => '困难',
];
?>

<div class="exam-page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-magic"></i> 智能组卷</h1>
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

<div class="container" style="padding-top:20px; max-width:700px;">
    <form method="post" class="smart-paper-form">
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">

        <div class="section-title"><i class="fas fa-sliders-h"></i> 组卷条件</div>

        <div class="form-row">
            <div class="form-group">
                <label>学段</label>
                <select name="period" id="period-select" class="form-control">
                    <?php foreach ($periods as $val => $label): ?>
                        <option value="<?= $val ?>"><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>学科 <span class="text-danger">*</span></label>
                <select name="course" id="course-select" class="form-control" required>
                    <option value="">请选择</option>
                    <?php foreach ($courses as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= Html::encode($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>难度</label>
                <select name="difficulty" class="form-control">
                    <?php foreach ($difficulties as $val => $label): ?>
                        <option value="<?= $val ?>"><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>题型</label>
                <select name="type" id="type-select" class="form-control">
                    <option value="">不限</option>
                    <?php foreach ($types as $t): ?>
                        <option value="<?= $t['id'] ?>"><?= Html::encode($t['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>出题数量</label>
                <input type="number" name="count" class="form-control" value="10" min="1" max="50">
            </div>
            <div class="form-group">
                <label>试卷标题</label>
                <input type="text" name="title" class="form-control" placeholder="自动生成标题">
            </div>
        </div>

        <div style="text-align:center;margin-top:16px">
            <button type="submit" class="btn exam-btn exam-btn-primary" style="min-width:200px">
                <i class="fas fa-magic"></i> 智能生成
            </button>
        </div>
    </form>

    <!-- Results -->
    <?php if ($papers !== null): ?>
        <div style="margin-top:24px">
            <div class="exam-form-section">
                <div class="section-title"><i class="fas fa-list"></i> 生成的试题</div>
                <?php if (empty($papers['items'])): ?>
                    <div class="exam-empty">
                        <div class="empty-icon">😕</div>
                        <div class="empty-text">没有找到符合条件的试题</div>
                        <div class="empty-hint">请放宽筛选条件后重试</div>
                    </div>
                <?php else: ?>
                    <?php foreach ($papers['items'] as $q): ?>
                        <div class="question-card" style="margin-bottom:8px">
                            <div class="q-header">
                                <?php
                                    $typeName = '题';
                                    foreach ($types as $t) {
                                        if ($t['id'] == ($q->type ?? $q['type'])) { $typeName = $t['name']; break; }
                                    }
                                ?>
                                <span class="exam-badge exam-badge-primary"><?= Html::encode($typeName) ?></span>
                            </div>
                            <div class="q-content">
                                <?= Html::encode(mb_substr(strip_tags($q->content ?? $q['content'] ?? ''), 0, 150)) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div style="text-align:center;margin-top:16px">
                        <a href="<?= Url::to(['create']) ?>" class="btn exam-btn exam-btn-primary">
                            <i class="fas fa-save"></i> 保存为试卷
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
$js = <<<JS
// 学段联动学科
$('#period-select').change(function() {
    var period = $(this).val();
    var \$course = $('#course-select');
    \$course.prop('disabled', true).empty().append('<option value="">加载中...</option>');
    $.getJSON('/exam/question/ajax-courses', {period: period}, function(res) {
        \$course.empty().append('<option value="">请选择</option>');
        if (res.success) {
            $.each(res.data, function(i, item) {
                \$course.append('<option value="' + item.id + '">' + item.name + '</option>');
            });
        }
        \$course.prop('disabled', false);
    });
    // 清空题型
    $('#type-select').empty().append('<option value="">不限</option>');
});

// 学科联动题型
$('#course-select').change(function() {
    var courseId = $(this).val();
    var \$type = $('#type-select');
    \$type.prop('disabled', true).empty().append('<option value="">加载中...</option>');
    if (!courseId) {
        \$type.empty().append('<option value="">不限</option>');
        \$type.prop('disabled', false);
        return;
    }
    $.getJSON('/exam/question/ajax-types', {course_id: courseId}, function(res) {
        \$type.empty().append('<option value="">不限</option>');
        if (res.success) {
            $.each(res.data, function(i, item) {
                \$type.append('<option value="' + item.id + '">' + item.name + '</option>');
            });
        }
        \$type.prop('disabled', false);
    });
});
JS;
$this->registerJs($js);
?>
