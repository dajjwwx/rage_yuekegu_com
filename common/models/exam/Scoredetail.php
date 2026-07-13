<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: stu_scoredetail (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $student_id
 * @property string $question_id
 * @property string $category_id
 * @property string $paper_id
 * @property string $question_num
 * @property string $class_id
 * @property string $set_score
 * @property string $real_score
 * @property string $rate
 */
class Scoredetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.stu_scoredetail';
    }

    /**
     * 返回主站数据库连接
     * @return \yii\db\Connection
     */
    public static function getDb()
    {
        return Yii::$app->db_yuekegu;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '',
            'student_id' => '',
            'question_id' => '',
            'category_id' => '',
            'paper_id' => '',
            'question_num' => '',
            'class_id' => '',
            'set_score' => '',
            'real_score' => '',
            'rate' => '',
        ];
    }
}
