<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: stu_homework (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $class_id
 * @property string $course
 * @property string $user_id
 * @property string $paper_id
 * @property string $created
 * @property string $is_virtual_class
 */
class Homework extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.stu_homework';
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
            'class_id' => '',
            'course' => '',
            'user_id' => '',
            'paper_id' => '',
            'created' => '',
            'is_virtual_class' => '',
        ];
    }
}
