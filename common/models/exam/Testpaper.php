<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sq_testpaper (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $title
 * @property string $course
 * @property string $created
 * @property string $allow_assistance
 * @property string $user_id
 * @property string $period
 * @property string $type
 * @property string $pid
 * @property string $grade
 * @property string $nianji
 * @property string $content
 */
class Testpaper extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sq_testpaper';
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
            'title' => '',
            'course' => '',
            'created' => '',
            'allow_assistance' => '',
            'user_id' => '',
            'period' => '',
            'type' => '',
            'pid' => '',
            'grade' => '',
            'nianji' => '',
            'content' => '',
        ];
    }
}
