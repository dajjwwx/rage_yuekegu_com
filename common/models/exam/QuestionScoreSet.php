<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sq_question_score_set (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $type
 * @property string $course
 * @property string $period
 * @property string $set_score
 * @property string $weight
 */
class QuestionScoreSet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sq_question_score_set';
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
            'type' => '',
            'course' => '',
            'period' => '',
            'set_score' => '',
            'weight' => '',
        ];
    }
}
