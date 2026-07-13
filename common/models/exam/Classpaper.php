<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: stu_classpaper (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $class
 * @property string $paper
 * @property string $is_virtual_class
 * @property string $pub_date
 */
class Classpaper extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.stu_classpaper';
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
            'class' => '',
            'paper' => '',
            'is_virtual_class' => '',
            'pub_date' => '',
        ];
    }
}
