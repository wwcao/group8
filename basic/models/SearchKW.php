<?php
namespace app\models;

use yii\base\Model;

class SearchKW extends Model
{
    public $keywords;
    public function rules()
    {
        return [
            [['keywords'], 'required'],
        ];
    }
}