<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: ss_subject (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $course
 * @property string $sid
 * @property string $period
 * @property string $rate
 */
class Subject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.ss_subject';
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
            'course' => '',
            'sid' => '',
            'period' => '',
            'rate' => '',
        ];
    }
}
