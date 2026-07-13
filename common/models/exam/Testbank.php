<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: stb_testbank (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $title
 * @property string $period
 * @property string $course_id
 * @property string $baiduyun
 * @property string $grade
 * @property string $create_at
 * @property string $user_id
 * @property string $description
 */
class Testbank extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.stb_testbank';
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
            'period' => '',
            'course_id' => '',
            'baiduyun' => '',
            'grade' => '',
            'create_at' => '',
            'user_id' => '',
            'description' => '',
        ];
    }
}
