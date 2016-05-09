<?php 
namespace common\models;

use Yii;
use yii\db\ActiveRecord; 

class Setting extends ActiveRecord{

	public static function tableName(){
		return "Settings";
	}

	public function rules(){

		return [
			[['id'],'required'],
			[['value'],'safe'],
		];
	}
}

?>