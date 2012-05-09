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
				$model->lang=Yii::app()->language;
				$model->origin=$origin;
				$model->module=Yii::app()->controller->module->id;
				$model->controller=Yii::app()->controller->id;
				$model->action=Yii::app()->controller->action->id;
				$model->save();
				return $origin;
			}
	}
}