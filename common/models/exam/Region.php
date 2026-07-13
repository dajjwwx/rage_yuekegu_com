<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sb_region (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $region
 * @property string $pid
 * @property string $uid
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sb_region';
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
            'region' => '',
            'pid' => '',
            'uid' => '',
        ];
    }
}
