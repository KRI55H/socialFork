<?php

namespace Kri55h;

use Exception;
use function shell_exec;

class SocialFork
{
    private $videoURL,$fileName,$filePath;

    private bool $isMerged = false;

    function __construct()
    {
        $this->filePath = $this->base_path();
        $this->fileName = "socialFork_".date('dmYHis');
    }

    private function base_path($append = '') : string
    {
        $basePath = __DIR__;

        while ($basePath !== dirname($basePath)) {
            $basePath = dirname($basePath);
        }
        return $basePath . DIRECTORY_SEPARATOR . $append;
    }

    public function setUrl(string $url) : SocialFork
    {
        $this->videoURL = $url;
        return $this;
    }

    public function setName(string $name): SocialFork
    {
        $this->fileName = $name;
        return $this;
    }

    public function setDownloadPath(string $path): SocialFork
    {
        $this->filePath = $path;
        return $this;
    }

    function combineAudioAndVideo(bool $action = true) : SocialFork
    {
        $this->isMerged = $action;
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

        $command = shell_exec("ffmpeg -version");
        if($command === null){
            throw new Exception("ffmpeg not found, please install ffmpeg");
        }

        $fileName       = $this->fileName;
        $filePath       = $this->filePath;
        $videoUrl       = $this->videoURL;
        if($this->isMerged){
            $download = shell_exec("yt-dlp --playlist-start 1 --playlist-end 1 -f bestvideo+bestaudio --merge-output-format mp4  -o '$filePath/$fileName.%(ext)s' $videoUrl 2>&1");
        }else{
            $download = shell_exec("yt-dlp --playlist-start 1 --playlist-end 1 -o '$filePath/$fileName.%(ext)s' --format best $videoUrl 2>&1");
        }

        if($download === null){
            $lastError = error_get_last();
            $errorMessage = isset($lastError['message']) ? $lastError['message'] : "";
            throw new Exception("Error while downloading video: $errorMessage");
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

        $command = shell_exec("ffmpeg -version");
        if($command === null){
            throw new Exception("ffmpeg not found, please install ffmpeg");
        }

        $fileName = $this->fileName;
        $filePath = $this->filePath;
        $videoUrl = $this->videoURL;
        if($this->isMerged){
            $commandString = "yt-dlp --playlist-start 1 --playlist-end 1 -o '$filePath/$fileName.%(ext)s' -f bestvideo+bestaudio --merge-output-format mp4 -j $videoUrl";
        }else{
            $commandString = "yt-dlp --playlist-start 1 --playlist-end 1 -o '$filePath/$fileName.%(ext)s' -f b -j $videoUrl";
        }
        $commandString .= " 2>&1";
        $command = shell_exec($commandString);
        if($command === null){
            throw new Exception("Error while getting information !");
        }else{
            $data = json_decode($command,true);
            return $data;
        }
    }

}