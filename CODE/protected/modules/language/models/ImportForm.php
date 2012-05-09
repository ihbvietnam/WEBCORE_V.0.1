<?php 
class ImportForm extends CFormModel
{
    public $lang;
    public $file;
 
    //Get list languages which don't exist
    static function getList_languages(){
    	$configFile = dirname ( __FILE__ ).'/../config/'.DIRECTORY_SEPARATOR.'config_languages.php';
    	$tmp=require($configFile);
    	 foreach ($tmp as $code=>$item){
        	$tmp[$code]=Language::t(Yii::app()->language,'Backend.Language.List',$item);
        }
        return $tmp;
    }
	
	public function attributeLabels()
	{
		return array(
			'lang'=> Language::t(Yii::app()->language,'Backend.Language.Form','Language'),
			'file'=>Language::t(Yii::app()->language,'Backend.Language.Import','File'),
		);
	}	
}
?>
