<?php

namespace Kri55h;

use Exception;

class socialFork
{
    private $videoURL,$fileName,$filePath;


    function __construct()
    {
        $this->filePath = $this->basePath();
        $this->fileName = "socialFork_".date('dmYHis');
    }

    private function basePath($append = '') : string
    {
        $basePath = __DIR__;

        while ($basePath !== dirname($basePath)) {
            $basePath = dirname($basePath);
        }
        return $basePath . DIRECTORY_SEPARATOR . $append;
    }

    public function setUrl(string $url) : socialFork
    {
        $this->videoURL = $url;
        return $this;
    }

    public function setName(string $name): socialFork
    {
        $this->fileName = $name;
        return $this;
    }

    public function setDownloadPath(string $path): socialFork
    {
        $this->filePath = $path;
        return $this;
    }

    public function download(): bool
    {
        if(!isset($this->videoURL) || empty($this->videoURL)){
            throw new Exception("Please enter post url");
        }

        $command = shell_exec("yt-dlp --version");
        if($command === null){
            throw new Exception("yt-dlp not found, please install yt-dlp");
        }

        $command = shell_exec("ffmpeg --version");
        if($command === null){
            throw new Exception("ffmpeg not found, please install ffmpeg");
        }

        $fileName       = $this->fileName;
        $filePath       = $this->filePath;
        $videoUrl       = $this->videoURL;
        $download = shell_exec("yt-dlp -o '$filePath/$fileName.%(ext)s' --format best $videoUrl 2>&1");

        if($download === null){
            throw new Exception("Error while downloading video !");
        }else{
            return true;
        }
    }

    public function getInfo(): array
    {
        if(!isset($this->videoURL) || empty($this->videoURL)){
            throw new Exception("Please enter post url");
        }

        $command = shell_exec("yt-dlp --version");
        if($command === null){
            throw new Exception("yt-dlp not found, please install yt-dlp");
        }

        $command = shell_exec("ffmpeg --version");
        if($command === null){
            throw new Exception("ffmpeg not found, please install ffmpeg");
        }

        $fileName = $this->fileName;
        $filePath = $this->filePath;
        $videoUrl = $this->videoURL;
        $command = shell_exec("yt-dlp -o '$filePath/$fileName.%(ext)s' --format best -j $videoUrl");

        if($command === null){
            throw new Exception("Error while getting information !");
        }else{
            $data = json_decode($command,true);
            $fileUrl = parse_url($data['filename'],PHP_URL_PATH);
            $elements = explode("/",$fileUrl);

            $responseData['id'] = $data['id'];
            $responseData['title'] = $data['title'];
            $responseData['description'] = $data['description'];
            $responseData['filename'] = end($elements);
            $responseData['file_url'] = $data['filename'];
            $responseData['thumbnail'] = $data['thumbnail'];
            return $responseData;
        }
    }

}