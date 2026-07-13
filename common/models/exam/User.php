<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sb_user (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $role
 * @property string $created_at
 * @property string $lastlogin
 * @property string $identification
 * @property string $auth_key
 * @property string $password_reset_token
 * @property string $updated_at
 * @property string $status
 * @property string $email
 * @property string $avatar
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sb_user';
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
            'username' => '',
            'password' => '',
            'salt' => '',
            'role' => '',
            'created_at' => '',
            'lastlogin' => '',
            'identification' => '',
            'auth_key' => '',
            'password_reset_token' => '',
            'updated_at' => '',
            'status' => '',
            'email' => '',
            'avatar' => '',
        ];
    }
}
