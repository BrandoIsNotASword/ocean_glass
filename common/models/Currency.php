<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Currency extends ActiveRecord
{
	public static function tableName()
	{
		return "Currencies";
	}
	public function rules()
	{
		return [
		];
	}
}