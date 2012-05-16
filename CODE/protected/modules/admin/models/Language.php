<?php
/**
 * 
 * Language class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * Language includes attributes and methods of Language class  
 */
class Language extends CActiveRecord
{
	/**
	 * @const string set Vietnamese as default language 
	 */
	const DEFAULT_LANGUAGE='vi';
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_language';
	}
	/**
	 * @return array validation rules for model attributes.
	 */	
	public function rules()
	{
		return array(
			array('lang,origin,controller,action','required'),
		);
	}
	/**
	 * 
	 * static function using to translate content
	 * @param string $origin content to be translated
	 * @return string, translated content
	 */	
	public static function t($origin) {
			$criteria = new CDbCriteria ();
			$criteria->compare('lang', Yii::app()->language);
			$criteria->compare('origin',$origin);
			$criteria->compare('module',Yii::app()->controller->module->id);
			$criteria->compare('controller',Yii::app()->controller->id);
			$criteria->compare('action',Yii::app()->controller->action->id);
			$model = self::model ()->find ( $criteria );
			if(isset($model)){
				if($model->translation != '')
					return $model->translation;
				else
					return $origin;
			}
			else{
				$model=new Language();
				if(!in_array(Yii::app()->language,array_keys(LanguageForm::getList_languages_exist()))){
					$list_all=LanguageForm::getList_all_languages();
					$list_language=LanguageForm::getList_languages_exist()+array(Yii::app()->language=>$list_all[Yii::app()->language]);
				}
				else 
					$list_language=LanguageForm::getList_languages_exist();
				foreach ( $list_language as $code=>$language){
					$model=new Language();
					$model->lang=$code;
					$model->origin=$origin;
					$model->module=Yii::app()->controller->module->id;
					$model->controller=Yii::app()->controller->id;
					$model->action=Yii::app()->controller->action->id;
					$model->save();
				}
				return $origin;
			}
	}
}