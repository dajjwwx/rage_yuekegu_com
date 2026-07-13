<?php

use common\helpers\Html;
use common\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = '添加题目 - ' . Html::encode($testpaper->title);
$this->params['breadcrumbs'][] = ['label' => '试卷管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Html::encode($testpaper->title), 'url' => ['view', 'id' => $testpaper->id]];
$this->params['breadcrumbs'][] = ['label' => '题目管理', 'url' => ['questions', 'id' => $testpaper->id]];
$this->params['breadcrumbs'][] = '添加题目';
?>

<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $this->title; ?></h3>
            </div>
            <div class="box-body">
                <form action="<?= Url::to(['add-question', 'id' => $testpaper->id]) ?>" method="post">
                    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">题目ID</label>
                                <input type="text" name="question_id" class="form-control" required placeholder="请输入题目ID">
                                <span class="help-block">输入需要添加到试卷的题目ID</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">分值</label>
                                <input type="number" name="score" class="form-control" value="5" min="1" step="0.5">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">题型</label>
                                <select name="question_type" class="form-control">
                                    <option value="0">请选择（可留空）</option>
                                    <?php foreach ($types as $type): ?>
                                    <option value="<?= $type['id'] ?>"><?= Html::encode($type['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">确认添加</button>
                        <?= Html::a('返回题目管理', ['questions', 'id' => $testpaper->id], ['class' => 'btn btn-white']); ?>
                    </div>
                </form>

                <hr>

                <h4>可选试题列表（最近100条）</h4>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>题型</th>
                            <th>内容摘要</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($questionList as $q): ?>
                        <tr>
                            <td><?= $q->id ?></td>
                            <td>
                                <?php
                                $typeList = ArrayHelper::map($types, 'id', 'name');
                                echo $typeList[$q->type] ?? $q->type;
                                ?>
                            </td>
                            <td style="max-width: 400px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <?= Html::encode(mb_substr($q->content, 0, 80)) ?>
                            </td>
                            <td>
                                <?= Html::a('查看', ['/exam/question/view', 'id' => $q->id], [
                                    'class' => 'btn btn-info btn-sm',
                                    'target' => '_blank',
                                ]) ?>
                                <button type="button" class="btn btn-success btn-sm btn-use-question"
                                    data-id="<?= $q->id ?>"
                                    data-type="<?= $q->type ?>"
                                    title="选择此题">
                                    选择
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
// 注册JS - 点击"选择"按钮自动填入ID和题型
$js = <<<JS
$(document).ready(function() {
    $('.btn-use-question').on('click', function() {
        var id = $(this).data('id');
        var type = $(this).data('type');
        $('input[name="question_id"]').val(id);
        $('select[name="question_type"]').val(type);
        $('input[name="question_id"]').focus();
    });
});
JS;
$this->registerJs($js);
?>
