<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sq_course_combination (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $type
 * @property string $courses
 */
class CourseCombination extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sq_course_combination';
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
            'courses' => '',
        ];
    }
}
