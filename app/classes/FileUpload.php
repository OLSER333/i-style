<?php

namespace App\Classes;

use SplFileInfo;

use const App\ROOT\ABSPATH;

class FileUpload
{
    public array $errors = [];

    function __construct(array $fileInput, string $uploadFolder, string|array $mimeType, int $maxFileSizeMB = 100, bool $setOriginalName = true)
    {
        if(empty($fileInput['tmp_name'])) {
            $this->errors[] = 'Файл не выбран';
            return;
        }

        $this->input = $fileInput;
        $this->mimeType = mime_content_type($fileInput['tmp_name']);
        $this->basename = basename($fileInput['name']);

        if($fileInput['size']/1000000 > $maxFileSizeMB)
            $this->errors[] = 'Размер файла слишком большой';

        if(is_array($mimeType)) {
            if(!in_array($this->mimeType, $mimeType)) {
                $this->errors[] = 'Неправильный формат файла';
            }
        } else if($this->mimeType !== $mimeType) {
            $this->errors[] = 'Неправильный формат файла';
        }
        $info = new SplFileInfo($this->basename);
        $this->ext = $info->getExtension();
        
        if(!$setOriginalName) {
            $this->newName();
        } else {
            $this->filename = str_replace(' ', '-', $this->basename);
            $this->name = $info->getFilename();
        }

        $this->uploadFolder = trim($uploadFolder, '/');
        $this->uploadPath = $uploadFolder .'/'. $this->filename;
    }

    function newName()
    {
        $this->name = md5(time().'-'.mt_rand(1000, 9999));
        $this->filename = $this->name.".".$this->ext;
    }

    function upload()
    {
        
        if(!empty($this->errors))
            return false;

        if(!file_exists(ABSPATH.'/'.$this->uploadFolder))
            mkdir(ABSPATH.'/'.$this->uploadFolder, 0777, true);

        if(move_uploaded_file($this->input['tmp_name'], ABSPATH.'/'.$this->uploadPath))
            return true;
        else
            $this->errors[] = 'Ошибка загрузки файла';
    }
}