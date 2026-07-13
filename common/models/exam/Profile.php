<?php

namespace common\models\exam;

use Yii;

/**
 * 
 * 
 * 表名: sb_profile (yuekegu 库)
 *
 * @property int $id
 * @property string $id
 * @property string $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string $nickname
 * @property string $avatar
 * @property string $gender
 * @property string $calendar
 * @property string $birth
 * @property string $birthyear
 * @property string $birthmonth
 * @property string $birthday
 * @property string $blood
 * @property string $marry
 * @property string $email
 * @property string $phone
 * @property string $qq
 * @property string $alipay
 * @property string $job
 * @property string $companyname
 * @property string $companyaddress
 * @property string $primaryschool
 * @property string $middleschool
 * @property string $highschool
 * @property string $university
 * @property string $country
 * @property string $province
 * @property string $manicipal
 * @property string $village
 * @property string $county
 * @property string $homeprovince
 * @property string $homemanicipal
 * @property string $homecounty
 * @property string $homevillage
 * @property string $addressdetail
 * @property string $homeaddressdetail
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yuekegu.sb_profile';
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
            'user_id' => '',
            'firstname' => '',
            'lastname' => '',
            'nickname' => '',
            'avatar' => '',
            'gender' => '',
            'calendar' => '',
            'birth' => '',
            'birthyear' => '',
            'birthmonth' => '',
            'birthday' => '',
            'blood' => '',
            'marry' => '',
            'email' => '',
            'phone' => '',
            'qq' => '',
            'alipay' => '',
            'job' => '',
            'companyname' => '',
            'companyaddress' => '',
            'primaryschool' => '',
            'middleschool' => '',
            'highschool' => '',
            'university' => '',
            'country' => '',
            'province' => '',
            'manicipal' => '',
            'village' => '',
            'county' => '',
            'homeprovince' => '',
            'homemanicipal' => '',
            'homecounty' => '',
            'homevillage' => '',
            'addressdetail' => '',
            'homeaddressdetail' => '',
        ];
    }
}
