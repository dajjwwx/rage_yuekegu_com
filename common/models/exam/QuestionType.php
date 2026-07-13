<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sq_question_type (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $name
 * @property string $description
 */
class QuestionType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sq_question_type';
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
            'name' => '',
            'description' => '',
        ];
    }
}
