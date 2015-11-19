<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "groups".
 *
 * @property string $groupname
 * @property string $l_user
 * @property resource $descripton
 * @property string $create_date
 * @property string $status
 *
 * @property Groupmembers[] $groupmembers
 */
class Groups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groupname', 'l_user', 'descripton'], 'required'],
            [['descripton'], 'string'],
            [['create_date'], 'safe'],
            [['groupname', 'l_user'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 1]
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
            'descripton' => 'Descripton',
            'create_date' => 'Create Date',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupmembers()
    {
        return $this->hasMany(Groupmembers::className(), ['groupname' => 'groupname', 'l_user' => 'l_user']);
    }

    /**
     * @inheritdoc
     * @return GroupsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GroupsQuery(get_called_class());
    }
}
