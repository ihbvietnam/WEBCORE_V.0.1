<?php 
class LanguageForm extends CFormModel
{
	const DEFAULT_MODULE='Common';
	const DEFAULT_GROUP=Language::BACK_END;
	public $origin_lang;
    public $lang;
    public $group;
    public $module;
    public $type;
	public $list_records;
	static $config=array();
  	public function init() { 
    	//Load file config
    	$list_setting_value = require (dirname ( __FILE__ ).'/../config/'.DIRECTORY_SEPARATOR.'list_setting_value.php');
    	$list_languages= require (dirname ( __FILE__ ).'/../config/'.DIRECTORY_SEPARATOR.'config_languages.php'); 
    	$configFile = dirname ( __FILE__ ).'/../config/'.DIRECTORY_SEPARATOR.'config_records.php';
    	$tmp=require($configFile); 
    	$list_params=SettingParam::model()->findAll();	
    	foreach($list_params as $params){
    		if($params->label != "")
    			$tmp[Language::BACK_END]['Admin']['Setting'][$params->label]=$params->label;
    		if($params->value != "" && in_array($params->name,$list_setting_value))
    			$tmp[Language::BACK_END]['Admin']['Setting-Value'][$params->name]=$params->value;
    		if($params->setting_group != "")	
    			$tmp[Language::BACK_END]['Admin']['Setting-Group'][$params->setting_group]=$params->setting_group;
    	}
    	foreach ($list_languages as $language){
    		$tmp[Language::BACK_END]['Language']['List'][$language]=$language;
    	}
    	self::$config=$tmp;
    }
    //Get list delete records
    public function getList_delete_languages(){
    	//$list_languages_params = SettingParam::model()->find('name=:name',array(':name'=>'LIST_LANG'));
        //$value = $list_languages_params->value;
        //$list_languages_exist=(array)json_decode($value);
        $dbCommand = Yii::app()->db->createCommand("
   			SELECT lang FROM `language` GROUP BY `lang`
		");
		$data = $dbCommand->queryAll();
		$list_languages_exist=array();
		//Get list all language
		$configFile = dirname ( __FILE__ ).'/../config/'.DIRECTORY_SEPARATOR.'config_languages.php';
    	$list=require($configFile);  
		foreach ($data as $item){
			if($item['lang']!=Language::DEFAULT_LANGUAGE)
				$list_languages_exist[$item['lang']]=Language::t(Yii::app()->language,'Backend.Language.List',$list[$item['lang']]);			
		}
        return $list_languages_exist;    	
    }
 	//Get list old records 
	public function getList_old_records(){	
		$result=array();
		if(in_array($this->lang,array_keys(self::getList_languages_exist()))){
			$criteria=new CDbCriteria;
			$criteria->compare('lang', $this->lang);
			$criteria->compare('`group`', $this->group);
			$criteria->compare('module', $this->module);
 			//Set list records
    		$list=Language::model()->findAll($criteria);
    		foreach ($list as $record){
    			if(!isset($result[$record->group])) $result[$record->group]=array();
    			if(!isset($result[$record->group][$record->module])) $result[$record->group][$record->module]=array();
    			if(!isset($result[$record->group][$record->module][$record->type])) $result[$record->group][$record->module][$record->type]=array();
    			$result[$record->group][$record->module][$record->type][$record->code]=$record->value;
    		}
    		$result=array_merge(self::$config,$result);
		}
		return $result;
    }
    //Get list existing languages
 	static function getList_languages_exist(){	
    	//$list_languages_params = SettingParam::model()->find('name=:name',array(':name'=>'LIST_LANG'));
        //$value = $list_languages_params->value;
        //$list_languages_exist=(array)json_decode($value);
        $dbCommand = Yii::app()->db->createCommand("
   			SELECT lang FROM `language` GROUP BY `lang`
		");
		$data = $dbCommand->queryAll();
		$list_languages_exist=array();
		//Get list all language
		$configFile = dirname ( __FILE__ ).'/../config/'.DIRECTORY_SEPARATOR.'config_languages.php';
    	$list=require($configFile);  
		foreach ($data as $item){
			$list_languages_exist[$item['lang']]=Language::t(Yii::app()->language,'Backend.Language.List',$list[$item['lang']]);			
		}
        return $list_languages_exist;
    }
    //Get list languages which don't exist
    static function getList_languages_not_exist(){
        $configFile = dirname ( __FILE__ ).'/../config/'.DIRECTORY_SEPARATOR.'config_languages.php';
    	$list=require($configFile); 
    	foreach ($list as $code=>$item){
        	$list[$code]=Language::t(Yii::app()->language,'Backend.Language.List',$item);
        }
        $list_languages_exist=self::getList_languages_exist();
        $tmp=array_diff($list, $list_languages_exist);        
        return $tmp;
    }
	
	//Get records which have updated
	public function getList_change_records() {
		$result=array();
		if (sizeof ( $this->list_old_records ) == 0)
			$result=$this->list_records;
		else {
			foreach ( $this->list_records as $index_group => $list_groups ) {
				foreach ( $list_groups as $index_module => $list_modules ) {
					foreach ( $list_modules as $index_type => $list_type ) {
						foreach ( $list_type as $index => $record ) {
							if(!isset($this->list_old_records[$index_group][$index_module][$index_type][$index]) || $this->list_old_records[$index_group][$index_module][$index_type][$index] != $this->list_records[$index_group][$index_module][$index_type][$index])
							{	
								if(!isset($result[$index_group])) $result[$index_group]=array();
    							if(!isset($result[$index_group][$index_module])) $result[$index_group][$index_module]=array();
    							if(!isset($result[$index_group][$index_module][$index_type])) $result[$index_group][$index_module][$index_type]=array();
								$result[$index_group][$index_module][$index_type][$index]=$this->list_records[$index_group][$index_module][$index_type][$index];
							}
						}
					}
				}
			}
		}
		return $result;
	}
    //Get list value of attribute group
	public function getList_groups(){
    	return array(
    		Language::BACK_END=>Language::t(Yii::app()->language,'Backend.Language.Form','Back end'),
    		Language::FRONT_END=>Language::t(Yii::app()->language,'Backend.Language.Form','Front end')
    	);	
    }
     //Get list value of attribute module
	public function getList_modules(){
		if($this->group==Language::BACK_END)
    		return array(
    	    	'Common'=>Language::t(Yii::app()->language,'Backend.Language.Common','Common'),
    			'System'=>Language::t(Yii::app()->language,'Backend.Language.Common','System'),
    			'Ads'=>Language::t(Yii::app()->language,'Backend.Common.Menu','Ads'),
    			'Admin'=>Language::t(Yii::app()->language,'Backend.Language.Common','Admin'),
    			'User'=>Language::t(Yii::app()->language,'Backend.Common.Common','User'),
    			'Money'=>Language::t(Yii::app()->language,'Backend.Language.Common','Money'),
    			'Map'=>Language::t(Yii::app()->language,'Backend.Map.Setting','Map'),
    			'Message'=>Language::t(Yii::app()->language,'Frontend.Ads.Reply','Message'),
    			'Appearance'=>Language::t(Yii::app()->language,'Backend.Common.Menu','Appearance'),
    			'Article'=>Language::t(Yii::app()->language,'Backend.Article.Admin','Article'),
    			'Language'=>Language::t(Yii::app()->language,'Frontend.Language.Form','Language'),
    		);	
    	else 
    		return array(
    	    	'Common'=>Language::t(Yii::app()->language,'Backend.Language.Common','Common'),
    			'Ads'=>Language::t(Yii::app()->language,'Backend.Common.Menu','Ads'),
    			'User'=>Language::t(Yii::app()->language,'Backend.Common.Common','User'),
    			'GenericContent'=>Language::t(Yii::app()->language,'Backend.Language.Common','GenericContent'),
    		);	
    }
	public function attributeLabels()
	{
		return array(
			'lang'=> Language::t(Yii::app()->language,'Backend.Language.Form','Language'),
			'origin_lang'=> Language::t(Yii::app()->language,'Backend.Language.Form','Copy Translation From'),
			'group'=>Language::t(Yii::app()->language,'Backend.Language.Form','Group'),
			'module'=>Language::t(Yii::app()->language,'Backend.Language.Form','Module'),
		);
	}
	public function setCategory($language,$group,$module){
		$this->lang=$language;
		$this->group=$group;
		$list_modules=$this->list_modules;
		if(isset($list_modules[$module]))
			$this->module=$module;
		else 	
		{
			reset($list_modules);
			$this->module = key ( $list_modules );
		}
		$criteria=new CDbCriteria;
		$criteria->compare('lang', $this->lang);
		$criteria->compare('`group`', $this->group);
		$criteria->compare('module', $this->module);
 		//Set list records
    	$list=Language::model()->findAll($criteria);
    	$tmp[$this->group]=array();
    	$tmp[$this->group][$this->module]=array();
    	$tmp[$this->group][$this->module]=self::$config[$this->group][$this->module];
    	foreach ($list as $record){
    		$tmp[$record->group][$record->module][$record->type][$record->code]=$record->value;
    	}
    	$this->list_records=$tmp;	
 	}
	public function setLanguage($language){
		$this->lang=$language;
		$criteria=new CDbCriteria;
		$criteria->compare('lang', $this->lang);
 		//Set list records
    	$list=Language::model()->findAll($criteria);
    	$tmp=self::$config;
    	foreach ($list as $record){
    		$tmp[$record->group][$record->module][$record->type][$record->code]=$record->value;
    	}
    	$this->list_records=$tmp;	
 	}
 	public function setData($input){
 		if(isset($input['lang']))
 			$this->lang=($input['lang']);
 		else 	
 			return false;
 		if(isset($input['group']))
 			$this->group=$input['group'];

 		if(isset($input['module']))
 			$this->module=$input['module'];
 			
 		if(isset($input['list_records']))
 			$this->list_records=$input['list_records'];		
 	}
 	public function saveArray2Data($list_old_records, $list_records) {
		$list = array ();
		if (sizeof ( $list_old_records ) == 0)
			$list = $list_records;
		else {
			foreach ( $list_records as $index_group => $list_groups ) {
				foreach ( $list_groups as $index_module => $list_modules ) {
					foreach ( $list_modules as $index_type => $list_type ) {
						foreach ( $list_type as $index => $record ) {
							if (! isset ( $list_old_records [$index_group] [$index_module] [$index_type] [$index] ) || $list_old_records [$index_group] [$index_module] [$index_type] [$index] != $list_records [$index_group] [$index_module] [$index_type] [$index]) {
								if (! isset ( $list [$index_group] ))
									$list [$index_group] = array ();
								if (! isset ( $list [$index_group] [$index_module] ))
									$list [$index_group] [$index_module] = array ();
								if (! isset ( $list [$index_group] [$index_module] [$index_type] ))
									$list [$index_group] [$index_module] [$index_type] = array ();
								$list [$index_group] [$index_module] [$index_type] [$index] = $list_records [$index_group] [$index_module] [$index_type] [$index];
							}
						}
					}
				}
			}
		}
 	foreach ( $list as $index_group => $list_groups ) {
			foreach ( $list_groups as $index_module => $list_modules ) {
				foreach ( $list_modules as $index_type => $list_type ) {
					foreach ( $list_type as $index => $attribute ) {
						$criteria=new CDbCriteria;
						$criteria->compare('lang',$this->lang);
						$criteria->compare('code', $index);
						$criteria->compare('`group`',$index_group);
						$criteria->compare('module',$index_module);
						$criteria->compare('type',$index_type);
						$model = Language::model()->find($criteria);
						if(isset($model))
							$model->value=$attribute;
						else {
							$model=new Language();
							$model->lang = $this->lang;
							$model->code = $index;
							$model->value = $attribute;
							$model->group = $index_group;
							$model->module = $index_module;
							$model->type = $index_type;
						}
						if(!$model->save ()) return false;
					}
				}
			}
		}
	return true;
	}
	public function saveData() {
		$list = $this->list_change_records;
		//$list=$this->list_records;
		foreach ( $list as $index_group => $list_groups ) {
			foreach ( $list_groups as $index_module => $list_modules ) {
				foreach ( $list_modules as $index_type => $list_type ) {
					foreach ( $list_type as $index => $attribute ) {
						$criteria=new CDbCriteria;
						$criteria->compare('lang',$this->lang);
						$criteria->compare('code', $index);
						$criteria->compare('`group`',$index_group);
						$criteria->compare('module',$index_module);
						$criteria->compare('type',$index_type);
						$model = Language::model()->find($criteria);
						if(isset($model))
							$model->value=$attribute;
						else {
							$model=new Language();
							$model->lang = $this->lang;
							$model->code = $index;
							$model->value = $attribute;
							$model->group = $index_group;
							$model->module = $index_module;
							$model->type = $index_type;
						}
						if(!$model->save ()) return false;
					}
				}
			}
		}
		return true;
	}
}
?>