<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/7
 * Time: 22:13
 */

namespace App\Services;


class ImageUploads
{

    protected $file;

    public function uploadAvatar($file)
    {
        $this->file = $file;

        $allowedExtensions = ["png", "jpg", "jpeg", "gif"];
        $check = $this->check($allowedExtensions);
        if (!$check['status']) {
            return $check;
        }

        $destPath = public_path('uploads/avatar');

        $newFileName = md5(time() . rand(0, 10000)) . '.' . $this->file->getClientOriginalExtension();

        if (!$this->file->move($destPath, $newFileName)) {
            return ['status' => false, 'msg' => '系统异常，文件保存失败'];
        }

        return ['status' => true, 'fileName' => $newFileName];

    }

    /**
     * @param $allowedExtensions
     * @return array|bool
     */
    private function check($allowedExtensions)
    {
        if (!$this->file->isValid()) {
            return ['status' => false, 'msg' => '文件上传失败'];
        }

        if (!$this->checkAllowedExtensions($allowedExtensions)) {
            return ['status' => false, 'msg' => '非法的图片格式'];
        }

        if ($this->file->getSize() > 2 * 1024 * 1024) {
            return ['status' => false, 'msg' => '图片大小不能大于2M'];
        }

        return ['status' => true];
    }

    /**
     * 检测上传文件格式是否合法
     * Check whether the upload file is legal.
     * @param $allowedExtensions
     * @return bool
     */
    private function checkAllowedExtensions($allowedExtensions)
    {
        //获取文件后缀名进行检查
        if (!in_array(strtolower($this->file->getClientOriginalExtension()), $allowedExtensions)) {
            return false;
        }

        return true;
    }
}