<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class SaleItem extends ActiveRecord
{
	public static function tableName()
	{
		return "SaleItems";
	}
	public function rules()
	{
		return [
			[['itemID','saleID','total','discount','color','sizeID','quantity'],'required'],
		];
	}
	public function getItem()
	{
		return $this->hasOne(Item::classname(),['id'=>'itemID']);
	}
	public function getSale()
	{
		return $this->hasOne(Sale::classname(),['id'=>'saleID']);
	}
	public function getPromotion()
	{
		return $this->hasOne(Promotion::classname(),['id'=>'promotionID']);
	}
	public function getSize()
	{
		return $this->hasOne(Size::classname(),['id'=>'sizeID']);
	}
	public function getColor()
	{
		return $this->hasOne(Color::classname(),['id'=>'colorID']);
	}
	public function attributeLabels()
	{
		return [
			// 'name'=>'Nombre',
			// 'description'=>'Descripcion',
		];
	}
}