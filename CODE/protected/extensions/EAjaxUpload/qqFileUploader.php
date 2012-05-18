<?php
/**
 * Handle file uploads via XMLHttpRequest
 */
class qqUploadedFileXhr {
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        $input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);

        if ($realSize != $this->getSize()){
            return false;
        }

        $target = fopen($path, "w");
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);

        return true;
    }
    function getName() {
        return $_GET['qqfile'];
    }
    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])){
            return (int)$_SERVER["CONTENT_LENGTH"];
        } else {
            throw new Exception('Getting content length is not supported.');
        }
    }
}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function getName() {
        return $_FILES['qqfile']['name'];
    }
    function getSize() {
        return $_FILES['qqfile']['size'];
    }
}

class qqFileUploader {
    private $allowedExtensions = array();
    private $sizeLimit = 2097152;
    private $file;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 2097152){
        $allowedExtensions = array_map("strtolower", $allowedExtensions);

        $this->allowedExtensions = $allowedExtensions;
        $this->sizeLimit = $sizeLimit;

        $this->checkServerSettings();

        if (isset($_GET['qqfile'])) {
            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES['qqfile'])) {
            $this->file = new qqUploadedFileForm();
        } else {
            $this->file = false;
        }
    }

    private function checkServerSettings(){
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));

        /*if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';
            die("{'error':'Please increase post_max_size and upload_max_filesize to $size'}");
        }*/
    }

    private function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;
        }
        return $val;
    }

    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE){
    	$image=new Image();
    	$image->src=$uploadDirectory;
    	$uploadDirectory=Yii::getPathOfAlias('webroot').'/'.$uploadDirectory.'/';
        if (!is_writable($uploadDirectory)){
            return array('error' => "Server error. Upload directory isn't writable.");
        }

        if (!$this->file){
            return array('error' => 'No files were uploaded.');
        }

        $size = $this->file->getSize();

        if ($size == 0) {
            return array('error' => 'File is empty');
        }

        if ($size > $this->sizeLimit) {
            return array('error' => 'File is too large');
        }

        $pathinfo = pathinfo($this->file->getName());
        $filename = $pathinfo['filename'];
        
        $ext = $pathinfo['extension'];

        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'File has an invalid extension, it should be one of '. $these . '.');
        }
    	if(!file_exists($uploadDirectory .'/origin')){
				mkdir($uploadDirectory .'/origin');
			}
        $filename=iPhoenixString::convertTitle($filename);
        if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory .'/origin/'. $filename . '.' . $ext)) {
                $filename = $filename.'-'.rand(10, 99);
            }
        }
        if ($this->file->save($uploadDirectory .'origin/'. $filename . '.' . $ext)){
        	$image->filename=$filename;
        	$image->extension=$ext;
        	$image->parent_attribute=$_GET['attribute'];
        	$image->category=$_GET['category'];
        	$image->parent_id=$_GET['parent_id'];
        	$type_image=isset($_GET['type_image'])?$_GET['type_image']:'thumb_update';
        	if($image->save()){
            	return array('success'=>true,'filename'=>$filename,'id'=>$image->id,'link_update'=>Yii::app()->createUrl('admin/image/update',array('id'=>$image->id)), 'url'=>$image->getThumb($image->category,$type_image));
        	}
        	else {
        		 return array('error'=> 'Không thể lưu lại file');
        	}
        } else {
            return array('error'=> 'Không thể lưu lại file');
        }

    }
}
