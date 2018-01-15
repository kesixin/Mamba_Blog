<?php


namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\Upload\DirDeleteRequest;
use App\Http\Requests\Backend\Upload\FileDeleteRequest;
use App\Http\Requests\Backend\Upload\MakeDirRequest;
use App\Http\Requests\Backend\Upload\UploadStoreRequest;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Services\UploadService;
use Mockery\Exception;

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
     * 文件上传保存
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
     * 创建目录
     * Create a new directory
     * @param MakeDirRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeDir(MakeDirRequest $request)
    {
        $path = rtrim($request->dir, '/') . "/" . $request->dir_name;
        if ($this->disk->exists($path)) {
            return response()->json(['status' => 1, 'msg' => '目录已存在']);
        }

        $status = [];
        try {
            if ($this->disk->makeDirectory($path)) {
                $status = ['status' => 0, 'msg' => '创建成功'];
            } else {
                throw new Exception('目录创建失败');
            }
        } catch (\Exception $e) {
            $status = ['status' => 1, 'msg' => $e->getMessage()];
        }

        return response()->json($status);
    }

    /**
     * 删除目录
     * Delete directory
     * @param DirDeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function dirDelete(DirDeleteRequest $request)
    {
        try {
            $this->disk->deleteDirectory($request->dir);
            return response()->json(['status' => 0]);
        } catch (\Exception $e) {
            return response()->json(['status' => 1, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * 删除文件
     * Delete file
     * @param FileDeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fileDelete(FileDeleteRequest $request)
    {
        try {
            $this->disk->delete($request->file);
            return response()->json(['status' => 0]);
        } catch (\Exception $e) {
            return response()->json(['status' => 1, 'msg' => $e->getMessage()]);
        }
    }

    public function uploadimage()
    {
        if (!$this->disk->exists('/article')) {
            $message = "article 文件夹不存在";
        }

        $data = array(
            'success' => empty($message) ? 1 : 0,
            'message' => $message,
            'url' => !empty($url) ? $url : ''
        );

        header('Content-Type:application/json;charset=utf8');
        exit(json_encode($data));
    }

}