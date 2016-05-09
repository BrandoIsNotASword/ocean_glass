<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Color extends ActiveRecord
{
	public static function tableName()
	{
		return "Colors";
	}
	public function rules()
	{
		return [
			[['name'],'required'],
			[['name'],'unique','message'=>"Este color ya existe!"],
		];
	}
}