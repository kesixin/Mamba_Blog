<?php


namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Services\UploadService;

class UploadController extends Controller
{

    protected $uploadService;
    protected $disk;

    /**
     * UploadController constructor.
     * @param UploadService $uploadService
     */
    public function __construct(UploadService $uploadService)
    {
        $this->uploadService=$uploadService;
        $disk = $this->uploadService->disk();
    }

    public function index(Request $request)
    {
        $dir = str_replace('\\', '/', $request->get('dir', '/'));
        $fileList = $this->uploadService->folderInfo($dir);
        return view('backend.upload.index',compact('fileList','dir'));

    }

}