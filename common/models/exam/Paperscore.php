<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: stu_paperscore (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $student_id
 * @property string $paper_id
 * @property string $question_id
 * @property string $answer
 * @property string $score
 * @property string $rate
 * @property string $status
 */
class Paperscore extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.stu_paperscore';
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
            'paper_id' => '',
            'question_id' => '',
            'answer' => '',
            'score' => '',
            'rate' => '',
            'status' => '',
        ];
    }
}
