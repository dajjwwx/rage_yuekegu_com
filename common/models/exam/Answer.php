<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sq_answer (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $question_id
 * @property string $content
 * @property string $user_id
 * @property string $analyze
 * @property string $answer
 * @property string $reliability
 * @property string $comment
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sq_answer';
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
            'question_id' => '',
            'content' => '',
            'user_id' => '',
            'analyze' => '',
            'answer' => '',
            'reliability' => '',
            'comment' => '',
        ];
    }
}
