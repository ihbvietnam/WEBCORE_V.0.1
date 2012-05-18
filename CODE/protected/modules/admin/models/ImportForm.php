<?php 
class ImportForm extends CFormModel
{
    public $lang;
    public $file;
    
	 public function rules()
    {
        return array(
        	array('lang','required'),
            array('file', 'file', 'types'=>'xlsx'),
        );
    }
	public function attributeLabels()
	{
		return array(
			'lang'=> 'Ngôn ngữ',
			'file'=>'File',
		);
	}	
}
?>
