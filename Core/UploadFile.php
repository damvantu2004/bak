<?php

trait UploadFile{
    protected $fileName;//tên file

    protected $fileExt;//phần mở rộng

    protected $rules;

    protected $folderUpload;

    protected $fileTemp;

    public function setFolderUpload($path){
        $this->folderUpload = $path;
    }

    public function getFolderUpload(){
        return $this->folderUpload;
    }
    
    public function setFileName($value){
        $this->fileName = $value;
    }

    public function getFileName(){
        return $this->fileName;
    }

    public function setFileTemp($value){
         $this->fileTemp = $value;
    }

    public function getFileTemp(){
        return $this->fileTemp;
    }
    public function upLoad(){
        move_uploaded_file($this->getFileTemp(), $this->getFolderUpload() . '/' . $this->getFileName());

        return $this->getFileName();
    }
}
