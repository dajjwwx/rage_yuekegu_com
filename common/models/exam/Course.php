<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sq_course (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $name
 * @property string $cname
 * @property string $pid
 * @property string $period
 * @property string $is_exam
 * @property string $type
 * @property string $weight
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sq_course';
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
            'cname' => '',
            'pid' => '',
            'period' => '',
            'is_exam' => '',
            'type' => '',
            'weight' => '',
        ];
    }
}
