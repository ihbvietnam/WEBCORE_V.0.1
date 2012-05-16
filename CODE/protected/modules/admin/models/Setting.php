<?php

class Setting extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tbl_setting';
	}
	public function rules()
	{
		return array(
			array('name,value','required'),
			array('name','unique')
		);
	}
	public function attributeLabels()
	{
		return array(
			'name' => 'Tên tham số',
			'value' => 'Giá trị',
		);
	}
/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'name', $this->name );
		if($this->module != 'all')
			$criteria->compare ( 'module', $this->module );
		$criteria->compare ( 'controller', $this->controller );
		$criteria->compare ( 'action', $this->action );
		if (isset ( $_GET ['pageSize'] ))
			Yii::app ()->user->setState ( 'pageSize', $_GET ['pageSize'] );
		return new CActiveDataProvider ( $this, array ('criteria' => $criteria, 'pagination' => array ('pageSize' => Yii::app ()->user->getState ( 'pageSize', Yii::app ()->params ['defaultPageSize'] ) ), 'sort' => array ('defaultOrder' => 'id DESC' )    		
		));
	}
/**
	 * Suggests a list of existing names matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of tags to be returned
	 * @return array list of matching username names
	 */
	public function suggestName($keyword,$limit=20)
	{
		$list_news=$this->findAll(array(
			'condition'=>'name LIKE :keyword',
			'order'=>'name DESC',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$names=array();
		foreach($list_news as $news)
			$names[]=$news->name;
			return $names;
	}
	//Get list module
	public function getList_modules(){
		$dbCommand = Yii::app()->db->createCommand("
   			SELECT module FROM `tbl_language` GROUP BY `module`
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
   			SELECT controller FROM `tbl_language` WHERE module = '$this->module' GROUP BY `controller`
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
   			SELECT action FROM `tbl_language` WHERE module =  '$this->module' AND controller ='$this->controller' GROUP BY `action`
		");
		$data = $dbCommand->queryAll();
		$list=array();	 
		foreach ($data as $item){
			$list[$item['action']]=$item['action'];			
		}
        return $list;
    } 	
	public static function s($name) {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'name', $name );
		if (isset ( Yii::app ()->controller->module->id ))
			$criteria->compare ( 'module', Yii::app ()->controller->module->id );
		else
			$criteria->compare ( 'module', '' );
		$criteria->compare ( 'controller', Yii::app ()->controller->id );
		$criteria->compare ( 'action', Yii::app ()->controller->action->id );
		$model = self::model ()->find ( $criteria );
		if (isset ( $model )) {
				return $model->value;
		} else {
			$model = new Setting ();
			$model->name = $name;
			$model->value = 1;
			if (isset ( Yii::app ()->controller->module->id ))
				$model->module = Yii::app ()->controller->module->id;
			else
				$model->module = '';
			$model->controller = Yii::app ()->controller->id;
			$model->action = Yii::app ()->controller->action->id;
			$model->save ();
			return $model->value;
		}
	}
}