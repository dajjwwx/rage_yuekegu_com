<?php

use yii\widgets\ActiveForm;
use common\helpers\Url;
use common\helpers\Html;
use yii\helpers\ArrayHelper;

/** @var ActiveForm $form */
/** @var \common\models\exam\Testpaper $model */
/** @var array $courses */

$form = ActiveForm::begin([
    'id' => $model->formName(),
    'enableAjaxValidation' => false,
    'fieldConfig' => [
        'template' => "<div class='row'><div class='col-sm-2 text-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div></div>",
    ]
]);
?>

<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">基本信息</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'title')->textInput([
                            'maxlength' => true,
                            'placeholder' => '请输入试卷标题',
                        ]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'course')->dropDownList(ArrayHelper::map($courses, 'id', 'name'), [
                            'prompt' => '请选择学科',
                        ]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'period')->textInput([
                            'maxlength' => true,
                            'placeholder' => '学段',
                        ]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'grade')->textInput([
                            'maxlength' => true,
                            'placeholder' => '年级',
                        ]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'nianji')->textInput([
                            'maxlength' => true,
                            'placeholder' => '年级（备选）',
                        ]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'type')->dropDownList([
                            '' => '请选择类型',
                            '1' => '练习',
                            '2' => '考试',
                            '3' => '模拟',
                        ]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'pid')->textInput([
                            'maxlength' => true,
                            'placeholder' => '上级ID',
                        ]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'allow_assistance')->dropDownList([
                            '' => '请选择',
                            '1' => '允许',
                            '0' => '不允许',
                        ]) ?>
                    </div>
                </div>

                <?= $form->field($model, 'content')->textarea([
                    'rows' => 4,
                    'placeholder' => '试卷描述',
                ]) ?>
            </div>

            <div class="box-footer text-center">
                <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('取消', ['index'], ['class' => 'btn btn-white']) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
