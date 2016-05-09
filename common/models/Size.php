<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Size extends ActiveRecord
{
	public static function tableName()
	{
		return "Sizes";
	}
	public function rules()
	{
		return [
			['name','required'],
			['description','order','safe'],
		];
	}
	public function attributeLabels()
	{
		return [
			'name'=>'Nombre',
			'description'=>'Descripcion',
		];
	}
}