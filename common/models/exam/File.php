<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sb_file (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $pid
 * @property string $status
 * @property string $iscomment
 * @property string $hits
 * @property string $islocal
 * @property string $server
 * @property string $name
 * @property string $tag
 * @property string $filetype
 * @property string $owner
 * @property string $created
 * @property string $size
 * @property string $extension
 * @property string $mime
 * @property string $links
 * @property string $remark
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sb_file';
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
            'pid' => '',
            'status' => '',
            'iscomment' => '',
            'hits' => '',
            'islocal' => '',
            'server' => '',
            'name' => '',
            'tag' => '',
            'filetype' => '',
            'owner' => '',
            'created' => '',
            'size' => '',
            'extension' => '',
            'mime' => '',
            'links' => '',
            'remark' => '',
        ];
    }
}
