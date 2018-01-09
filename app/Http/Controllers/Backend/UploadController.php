<?php


namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\Upload\MakeDirRequest;
use App\Http\Requests\Backend\Upload\UploadStoreRequest;
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
        $this->uploadService = $uploadService;
        $this->disk = $this->uploadService->disk();
    }

    /**
     * 文件管理页面
     * File management
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $dir = str_replace('\\', '/', $request->get('dir', '/'));
        $fileList = $this->uploadService->folderInfo($dir);
        return view('backend.upload.index', compact('fileList', 'dir'));

    }

    /**
     * 文件上传
     * File upload
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function fileUpload(Request $request)
    {
        $dir = $request->dir;
        if ($dir == "") {
            return redirect()->back()->withErrors('非法参数');
        }

        if (!$this->uploadService->dirExists($dir)) {
            return redirect()->back()->withErrors('目录不存在');
        }

        return view('backend.upload.upload', compact('dir'));
    }

    /**
     * 文件上传
     * @param UploadStoreRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function fileStore(UploadStoreRequest $request)
    {
        $response = $this->uploadService->uploadFile($request);

        if ($response['status']) {
            return redirect($response['url'])->with('success', '上传成功');
        }

        return redirect()->back()->withErrors($response['msg']);
    }


    /**
     * @param MakeDirRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeDir(MakeDirRequest $request)
    {
        $path = rtrim($request->dir, '/')."/".$request->dir_name;
        if ($this->disk->exists($path)) {
            return response()->json(['status' => 1, 'msg' => '目录已存在']);
        }
    }

}