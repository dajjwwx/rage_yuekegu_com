<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sq_question_splits (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $user_id
 * @property string $file_id
 * @property string $testpaper_id
 * @property string $question_id
 * @property string $question_num
 * @property string $question_type
 * @property string $created
 * @property string $x
 * @property string $y
 * @property string $w
 * @property string $h
 * @property string $coords
 */
class QuestionSplits extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sq_question_splits';
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
            'user_id' => '',
            'file_id' => '',
            'testpaper_id' => '',
            'question_id' => '',
            'question_num' => '',
            'question_type' => '',
            'created' => '',
            'x' => '',
            'y' => '',
            'w' => '',
            'h' => '',
            'coords' => '',
        ];
    }
}
