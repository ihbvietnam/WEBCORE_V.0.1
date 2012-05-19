<?php
/**
 * 
 * ImportForm class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * ImportForm includes attributes and methods of ImportForm class, using in import data into systems  
 */ 
class ImportForm extends CFormModel
{
	/**
	 * @var string $lang, language of the item
	 */
    public $lang;
    /**
     * @var FILE $file, file to be imported
     */
    public $file;    

	/**
	 * @return array validation rules for model attributes.
	 */    
	 public function rules()
    {
        return array(
        	array('lang','required'),
            array('file', 'file', 'types'=>'xlsx'),
        );
    }
	/**
	 * @return array customized attribute labels (name=>label)
	 */        
	public function attributeLabels()
	{
		return array(
			'lang'=> 'Ngôn ngữ',
			'file'=>'File',
		);
	}	
}
?>
