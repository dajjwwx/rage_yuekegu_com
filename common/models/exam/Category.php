<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sb_category (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $name
 * @property string $weight
 * @property string $type
 * @property string $description
 * @property string $pid
 * @property string $uid
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sb_category';
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
            'weight' => '',
            'type' => '',
            'description' => '',
            'pid' => '',
            'uid' => '',
        ];
    }
}
