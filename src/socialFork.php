<?php
namespace kri55h\socialfork;

use Exception;

class socialFork
{
    public $videoURL,$fileName,$filePath;

    function __construct()
    {

        $this->filePath = __DIR__;
        $this->fileName = "socialFork_".date('dmYHis');
    }

    function setUrl(string $url): static
    {
        $this->videoURL = $url;
        return $this;
    }

    function setName(string $name): static
    {
        $this->fileName = $name;
        return $this;
    }

    function setDownloadPath(string $path): static
    {
        $this->filePath = $path;
        return $this;
    }

    function download(): bool
    {
        if(!isset($this->videoURL) || empty($this->videoURL)){
            throw new Exception("Please enter post url");
        }

        $command = shell_exec("yt-dlp --version");
        if($command === null){
            throw new Exception("yt-dlp not found, please install yt-dlp");
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

    function getInfo(): array
    {
        if(!isset($this->videoURL) || empty($this->videoURL)){
            throw new Exception("Please enter post url");
        }

        $command = shell_exec("yt-dlp --version");
        if($command === null){
            throw new Exception("yt-dlp not found, please install yt-dlp");
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