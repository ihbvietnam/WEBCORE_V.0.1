<?php

class Language extends CActiveRecord
{
	const DEFAULT_LANGUAGE='vi';
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tbl_language';
	}
	public function rules()
	{
		return array(
			array('lang,origin,controller,action','required'),
		);
	}
	public static function t($origin) {
			$criteria = new CDbCriteria ();
			$criteria->compare('lang', Yii::app()->language);
			$criteria->compare('origin',$origin);
			if(isset(Yii::app()->controller->module->id))
				$criteria->compare('module',Yii::app()->controller->module->id);
			else 
				$criteria->compare('module','');
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
					if(isset(Yii::app()->controller->module->id))
						$model->module=Yii::app()->controller->module->id;
					else
						$model->module='';
					$model->controller=Yii::app()->controller->id;
					$model->action=Yii::app()->controller->action->id;
					$model->save();
				}
				return $origin;
			}
	}
}