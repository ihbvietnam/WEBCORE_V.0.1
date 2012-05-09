<?php
class LanguageSelector extends CInputWidget
{
    public $label;
    public $description;
    public $setting_group;
    public $ordering;
    public $visible;
    public $module;
        
    public function run()
    {
        $dbCommand = Yii::app()->db->createCommand("
   			SELECT lang FROM `language` GROUP BY `lang`
		");
		$data = $dbCommand->queryAll();
    	$list_languages=array();
		//Get list all language
		$configFile = dirname ( __FILE__ ).'/../config/'.DIRECTORY_SEPARATOR.'config_languages.php';
    	$list=require($configFile); 
		foreach ($data as $item){
			$list_languages[$item['lang']]=Language::t(Yii::app()->language,'Backend.Language.List',$list[$item['lang']]);			
		}
        echo CHtml::dropDownList($this->name,$this->value,$list_languages);    
    }
}