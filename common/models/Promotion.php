<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Promotion;
class Promotion extends ActiveRecord
{
	const DiscountTypePercentage = 1;
	const DiscountTypeAmount = 2;

	const TypeGarmentTypes = 1;
	const TypeItems = 2;

	public static function tableName()
	{
		return "Promotions";
	}
	public function rules()
	{
		return [
			[['name','value','discountType','type','startDate','endDate'],'required'],
			['value','number'],
			['priority','default','value'=>1],
			[['description','limit','uses','priority'],'safe'],
		];
	}
	public function getItems()
    {
        return $this->hasMany(Item::classname(),['id'=>'itemID'])
        ->viaTable('ItemsPromotions',['promotionID'=>'id']);
    }
	public function getGarmentTypes()
    {
        return $this->hasMany(GarmentType::classname(),['id'=>'garmentTypeID'])
        ->viaTable('GarmentTypesPromotions',['promotionID'=>'id']);
    }
    public function getDiscountTypeArray()
	{
		return [
			Promotion::DiscountTypePercentage => 'Porcentaje',
			Promotion::DiscountTypeAmount => 'Monto Fijo',
		];
	}
    public function getTypeArray()
	{
		return [
			Promotion::TypeGarmentTypes => 'Tipo de prenda',
			Promotion::TypeItems => 'Productos selectos',
		];
	}
	public function applyPromotion($amount)
	{
		if($this->discountType==Promotion::DiscountTypePercentage){
			$r = $amount*(1-$this->value/100);
		}else if($this->discountType==Promotion::DiscountTypeAmount){
			$r = $amount-$this->value;
		}
		return $r;
	}
}