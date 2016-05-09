<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\imagine\Image as Image2;
class Image extends ActiveRecord
{
	public static function getDb(){
		return Yii::$app->db2;
    }
	public static function tableName()
	{
		return self::getDbName().".Images";
	}
	public function rules()
	{
		return [
			['filename','required'],
			// ['isClothing','default','value'=>1],
		];
	}
	public function getItem()
	{
		return $this->hasOne(Item::className(),['id'=>'referenceID']);
	}
	public function generateThumbnails()
	{
		// generar 2 imagenes mas
		$tmpFilename = tempnam('./temp', 'tmp');
        file_put_contents($tmpFilename,$this->content);
		// medium 300x300px
        $this->medium = Image2::thumbnail($tmpFilename,300,300,\Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET)->get('png');
		// small 100x100px
        $this->small = Image2::thumbnail($tmpFilename,100,100,\Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET)->get('png');
        unlink($tmpFilename);
	}
	public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
        	$this->generateThumbnails();
            return true;
        }else{
            return false;
        }
    }
    public static function getDbName()
	{
		if (preg_match('/dbname=([^;]*)/',Yii::$app->db2->dsn,$match)) {
            return $match[1];
        } else {
            return null;
        }
	}
}