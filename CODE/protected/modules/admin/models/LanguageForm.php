<?php 
class LanguageForm extends CFormModel
{
	const DEFAULT_MODULES='admin';
	public $origin_lang;
	public $store_lang;
    public $lang;
    public $store_module;
    public $module;
    public $store_controller;
    public $controller;
    public $store_action;
    public $action;
	//Get list module
	public function getList_modules(){
		$dbCommand = Yii::app()->db->createCommand("
   			SELECT module FROM `tbl_language` WHERE lang = '$this->lang' GROUP BY `module`
		");
		$data = $dbCommand->queryAll();
		$list=array();	 
		foreach ($data as $item){
			$list[$item['module']]=$item['module'];			
		}
        return $list;
    }
 	//Get list controller
	public function getList_controllers(){
		$dbCommand = Yii::app()->db->createCommand("
   			SELECT controller FROM `tbl_language` WHERE lang = '$this->lang' AND module = '$this->module' GROUP BY `controller`
		");
		$data = $dbCommand->queryAll();
		$list=array();	 
		foreach ($data as $item){
			$list[$item['controller']]=$item['controller'];			
		}
        return $list;
    }
	//Get list action
	public function getList_actions(){
		$dbCommand = Yii::app()->db->createCommand("
   			SELECT action FROM `tbl_language` WHERE lang = '$this->lang' AND module =  '$this->module' AND controller ='$this->controller' GROUP BY `action`
		");
		$data = $dbCommand->queryAll();
		$list=array();	 
		foreach ($data as $item){
			$list[$item['action']]=$item['action'];			
		}
        return $list;
    } 	
    static function getList_all_languages(){
    	//Get list all language
		$configFile = dirname ( __FILE__ ).'/../config/'.DIRECTORY_SEPARATOR.'config_languages.php';
    	$list=require($configFile); 
    	return $list;
    }
    //Get list existing languages
 	static function getList_languages_exist(){	
        $dbCommand = Yii::app()->db->createCommand("
   			SELECT lang FROM `tbl_language` GROUP BY `lang`
		");
		$data = $dbCommand->queryAll();
		$list_languages_exist=array();	
		$list=self::getList_all_languages();	 
		foreach ($data as $item){
			$list_languages_exist[$item['lang']]=$list[$item['lang']];			
		}
        return $list_languages_exist;
    }
    //Get list languages which don't exist
    static function getList_languages_not_exist(){
    	$list=self::getList_all_languages();
        $list_languages_exist=self::getList_languages_exist();
        $tmp=array_diff($list, $list_languages_exist);        
        return $tmp;
    }
	//Get list delete records
    static function getList_delete_languages(){
        $dbCommand = Yii::app()->db->createCommand("
   			SELECT lang FROM `tbl_language` GROUP BY `lang`
		");
		$data = $dbCommand->queryAll();
		$list_delete_languages=array();	
		$list=self::getList_all_languages();	 
		foreach ($data as $item){
			if($item['lang']!=Language::DEFAULT_LANGUAGE)
				$list_delete_languages[$item['lang']]=$list[$item['lang']];			
		}
        return $list_delete_languages;    	
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
	/*
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('origin_lang,lang','required','on'=>'create'),
			array('lang','required','on'=>'delete'),
			array('lang,module,controller,action,store_lang,store_module,store_controller,store_action','safe','on'=>'edit')
		);
	}
	public function attributeLabels()
	{
		return array(
			'lang'=> Language::t('Ngôn ngữ'),
			'origin_lang'=> Language::t('Ngôn ngữ nguồn'),
			'module'=>Language::t('Module'),
			'controller'=>Language::t('Controller'),
			'action'=>Language::t('Action'),
		);
	}
	static function copyLanguage($origin_language,$language){
		$criteria=new CDbCriteria;
		$criteria->compare('lang', $origin_language);
    	$list=Language::model()->findAll($criteria);
    	foreach ($list as $origin_record){
    		$record= new Language();
    		$record->lang=$language;
    		$record->origin=$origin_record->origin;
    		$record->translation=$origin_record->translation;
    		$record->module=$origin_record->module;
    		$record->controller=$origin_record->controller;
    		$record->action=$origin_record->action;
    		if (!$record->save())
    			return false;
    	}	
    	return true;
 	}
	static function deleteLanguage($language){
		if ($language == Language::DEFAULT_LANGUAGE)
			return false;
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'lang', $language );
		$list = Language::model ()->findAll ( $criteria );
		foreach ( $list as $record ) {
			if (! $record->delete ())
				return false;
		}
		$setting = Setting::s('ADMIN_LANGUAGE');
		if ($language == $setting->value) {
			$setting->value = Language::DEFAULT_LANGUAGE;
			$setting->save ();
		}
		if ($language == Yii::app()->session['lang']) {
			Yii::app()->session['lang'] = Language::DEFAULT_LANGUAGE;
		}
		return true;
 	}
	public function search(){
		$criteria=new CDbCriteria;
		$criteria->compare('lang', $this->lang);
		$criteria->compare('module', $this->module);
		$criteria->compare('controller', $this->controller);
		$criteria->compare('action', $this->action);
		$criteria->order='origin';
    	$list=Language::model()->findAll($criteria);
    	return $list;
 	}	
	static function saveLanguage($list) {
		foreach ($list as $id=>$value){
			$record=Language::model()->findByPk($id);
			$record->translation=$value;
			$record->save();
		}
	}
}
?>