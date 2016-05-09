<?php 
namespace common\models;

use Yii;
use yii\db\ActiveRecord; 

class PaymentMethod extends ActiveRecord{
	public static function tableName(){
		return "PaymentMethods";
	}
	public function rules(){

		return [
			// [['title','key'],'required'],
			[['name','description','key'],'safe'],
		];
		
	}
}

?>