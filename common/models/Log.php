<?php 
namespace common\models;

use Yii;
use yii\db\ActiveRecord; 

class Log extends ActiveRecord{
	public static function tableName(){
		return "Logs";
	}

	public function rules(){

		return [
			[['env','data'],'required'],
		];
		
	}
}

?>