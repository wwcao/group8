<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "groupmembers".
 *
 * @property string $groupname
 * @property string $l_user
 * @property string $m_user
 *
 * @property Groups $groupname0
 */
class Groupmembers extends \yii\db\ActiveRecord
{
    public $m_users;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'groupmembers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groupname', 'l_user', 'm_user'], 'required'],
            [['groupname', 'l_user', 'm_user'], 'string', 'max' => 50],
            //['m_users', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'groupname' => 'Groupname',
            'l_user' => 'L User',
            'm_user' => 'M User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupname0()
    {
        return $this->hasOne(Groups::className(), ['groupname' => 'groupname', 'l_user' => 'l_user']);
    }
}
