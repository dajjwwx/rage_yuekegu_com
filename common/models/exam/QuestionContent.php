<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sq_question_content (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $question_id
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 */
class QuestionContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sq_question_content';
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
            'created_at' => '',
            'updated_at' => '',
        ];
    }
}
