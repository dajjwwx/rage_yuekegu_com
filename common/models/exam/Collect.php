<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sb_collect (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $type
 * @property string $ori_id
 * @property string $user_id
 * @property string $created
 * @property string $flag
 * @property string $update
 */
class Collect extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sb_collect';
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
            'ori_id' => '',
            'user_id' => '',
            'created' => '',
            'flag' => '',
            'update' => '',
        ];
    }
}
