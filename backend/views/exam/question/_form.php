<?php

use yii\widgets\ActiveForm;
use common\helpers\Url;
use common\helpers\Html;
use yii\helpers\ArrayHelper;

/** @var ActiveForm $form */
/** @var \common\models\exam\Question $model */
/** @var array $types */
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
                        <?= $form->field($model, 'type')->dropDownList(ArrayHelper::map($types, 'id', 'name'), [
                            'prompt' => '请选择题型',
                        ]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'course')->dropDownList(ArrayHelper::map($courses, 'id', 'name'), [
                            'prompt' => '请选择学科',
                        ]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'period')->textInput(['maxlength' => true, 'placeholder' => '学段']) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'score')->textInput(['maxlength' => true, 'placeholder' => '分值']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'category_ids')->textInput(['maxlength' => true, 'placeholder' => '分类ID，多个用逗号分隔']) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'source')->textInput(['maxlength' => true, 'placeholder' => '来源']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'source_num')->textInput(['maxlength' => true, 'placeholder' => '来源编号']) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'tags')->textInput(['maxlength' => true, 'placeholder' => '标签（逗号分隔）']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'status')->radioList([
                            '1' => '启用',
                            '0' => '禁用',
                        ]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'matching')->textInput(['maxlength' => true, 'placeholder' => '匹配标记']) ?>
                    </div>
                </div>

                <?= $form->field($model, 'content')->textarea([
                    'rows' => 6,
                    'placeholder' => '请输入试题题干内容',
                ]) ?>

                <?= $form->field($model, 'uuid')->hiddenInput()->label(false) ?>
            </div>

            <div class="box-footer text-center">
                <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                <?= Html::a('取消', ['index'], ['class' => 'btn btn-white']) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
