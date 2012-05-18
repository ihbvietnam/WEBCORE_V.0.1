<?php

class SearchForm extends CFormModel
{
	public $name;
	public $catid;
	public $start_price;
	public $end_price;
	public $list_end_price=array('0'=>'0','500000'=>'500.000','1000000'=>'1.000.000','2000000'=>'2.000.000','5000000'=>'5.000.000');
	public $list_start_price=array('0'=>'0','500000'=>'500.000','1000000'=>'1.000.000','2000000'=>'2.000.000','5000000'=>'5.000.000','-1'=>'Lớn nhất');
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('catid,start_price,end_price', 'numerical', 'integerOnly'=>true),
			array('name', 'safe'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
		);
	}
}