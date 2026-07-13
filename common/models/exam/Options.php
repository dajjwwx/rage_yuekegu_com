<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sb_options (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $uid
 * @property string $name
 * @property string $value
 */
class Options extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sb_options';
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
            'uid' => '',
            'name' => '',
            'value' => '',
        ];
    }
}
