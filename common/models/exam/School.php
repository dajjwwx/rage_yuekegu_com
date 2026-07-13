<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sb_school (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $name
 * @property string $city
 * @property string $type
 * @property string $website
 */
class School extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sb_school';
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
            'city' => '',
            'type' => '',
            'website' => '',
        ];
    }
}
