<?php

namespace App\Services;


use Dflydev\ApacheMimeTypes\PhpRepository;
use Illuminate\Support\Facades\Storage;
use File;

class UploadService
{

    protected $disk;

    protected $phpRepository;


    /**
     * UploadService constructor.
     * @param PhpRepository $phpRepository
     */
    public function __construct(PhpRepository $phpRepository)
    {
        $this->disk = Storage::disk(config('blog.uploads.storage'));
        $this->phpRepository = $phpRepository;
    }

    /**
     * @return \Illuminate\Filesystem\FilesystemAdapter
     */
    public function disk()
    {
        return $this->disk;
    }

    /**
     * 获取目录信息
     * Get directory information
     * @param $dir
     * @return array
     */
    public function folderInfo($dir)
    {
        $fileList = $this->fileInfo($dir);

        $dirList = $this->dirList($dir);

        return compact("fileList", "dirList");
    }

    /**
     * 保存上传文件
     * Save the upload file
     * @param $request
     * @return array
     */
    public function uploadFile($request)
    {
        $dir = "/" . trim(str_replace('\\', '/', $request->dir), '/') . "/";
        if (!$this->dirExists($dir)) {
            return ['status' => false, 'msg' => '目录不存在'];
        }

        $file = $request->file('file');
        $name = $request->name;

        $fileName = $name != "" ? $name : md5(time() . rand(0, 10000));
        $saveFile = $dir . $fileName . '.' . $file->getClientOriginalExtension();

        if ($this->disk->exists($saveFile)) {
            return ['status' => false, 'msg' => '文件名已存在或文件已存在'];
        }


        if($this->disk->put($saveFile,File::get($file->getPathname()))){
            $url = route('backend.upload.index', ['dir' => $dir]);
            return ['status' => true, 'url' => $url];
        }
        return ['status' => false, 'msg' => '上传失败'];
    }

    /**
     * 判断目录是否存在
     * Determine if the directory is exists.
     * @param $path
     * @return bool
     */
    public function dirExists($path)
    {
        if ($path != "/") {
            return $this->disk->exists($path);
        }

        return true;
    }

    /**
     * 获取目录列表
     * Get directory list
     * @param $dir
     * @return array
     */
    public function dirList($dir)
    {
        $list = $this->disk->directories($dir);
        $dirList = [];
        foreach ($list as $l) {
            $lArray = explode('/', str_replace('\\', '/', $l));
            $dirList[] = array_pop($lArray);
        }

        return $dirList;

    }

    /**
     * 文件信息
     * File info
     * @param $dir
     * @return array
     */
    public function fileInfo($dir)
    {
        $files = $this->disk->files($dir);

        $filesInfo = [];
        $webPath = config('blog.uploads.webPath');
        $host = url('/');

        if ($files) {
            foreach ($files as $file) {
                $temp = [];
                $temp['file_name'] = basename($file);
                $temp['mime_type'] = $this->getFileMimeType($file);
                $temp['size'] = $this->getFileSize($file);
                $temp['modified_date'] = $this->getLastModified($file);
                $temp['path'] = $host . $webPath . '/' . $file;

                $filesInfo[] = $temp;
            }
        }

        return $filesInfo;
    }

    /**
     * 获取文件
     * GetFileType
     * @param $path
     * @return mixed|null|string
     */
    public function getFileMimeType($path)
    {
        return $this->phpRepository->findType(pathinfo($path, PATHINFO_EXTENSION));
    }

    /**
     * 获取文件大小
     * Get the file size
     * @param $path
     * @return int
     */
    public function getFileSize($path)
    {
        return $this->disk->size($path);
    }

    /**
     * 获取文件的修改日期
     * Get the modified date of the files
     * @param $path
     * @return false|string
     */
    public function getLastModified($path)
    {
        return date("Y-m-d H:i:s", $this->disk->lastModified($path));
    }


}