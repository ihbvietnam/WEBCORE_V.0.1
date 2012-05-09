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
			'lang'=> Language::t('Ngôn ngữ'),
			'file'=>Language::t('File'),
		);
	}	
}
?>
