<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use common\models\ItemStock;

class Sale extends ActiveRecord
{
	// estados de pedido
	const StatusPending = 1;
	const StatusPayed = 2;
	const StatusCancelled = 3;
	const StatusFinished = 4;

	public static function tableName()
	{
		return "Sales";
	}
	public function rules()
	{
		return [
			[['total','status','token','clientName','clientEmail','clientAddress'],'required'],
			[['notes','cancelUserID'],'safe'],
		];
	}
	public function getSaleItems()
	{
		return $this->hasMany(SaleItem::classname(),['saleID'=>'id']);
	}
	public function getCancelUser()
	{
		return $this->hasOne(User::classname(),['id'=>'cancelUserID']);
	}
	public function attributeLabels()
	{
		return [
		];
	}
    public function getStatusArray()
	{
		return [
			self::StatusPending => 'Pendiente de Pago',
			self::StatusPayed => 'Pagado',
			self::StatusCancelled => 'Cancelado',
			self::StatusFinished => 'Terminado',
		];
	}
	public function discountInventory()
	{
		if(!$this->discountStock){
			foreach ($this->saleItems as $i){
				$aux = new ItemStock;
				$aux->itemID = $i->item->id;
				$aux->quantity = -$i->quantity;
				$aux->notes = "Venta ".$this->id;
				$aux->save();
				$i->item->updateStock();
			}			
			$this->discountStock = true;
			$this->save();
		}
	}
	public function recoverInventory()
	{
		if($this->discountStock){
			foreach ($this->saleItems as $i){
				$aux = new ItemStock;
				$aux->itemID = $i->item->id;
				$aux->quantity = $i->quantity;
				$aux->notes = "Cancelacion Venta ".$this->id;
				$aux->save();
			}
			$this->discountStock = false;
			$this->save();
		}
	}
}