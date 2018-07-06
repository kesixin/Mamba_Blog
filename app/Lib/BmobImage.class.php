<?php

include_once 'BmobRestClient.class.php';

/**
 * BmobUser batch对象类
 * @author karvinchen
 * @license http://www.gnu.org/copyleft/lesser.html Distributed under the Lesser General Public License (LGPL)
 */
class BmobImage extends BmobRestClient
{

    public function __construct($class = '')
    {
        parent::__construct();
    }




    /**
     * 生成缩微图
     * @param array $data 参数
     */
    public function imageThumbnail($data)
    {
        if (!empty($data)) {
            //重设对象的属性
            $this->cleanData();
            $this->data = $data;
            $sendRequest = $this->sendRequest(array(
                'method' => 'POST',
                'sendRequestUrl' => 'images/thumbnail',
                'data' => $this->data,
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }

    /**
     * 生成水印
     * @param array $data 参数
     */
    public function imagesWatermark($data)
    {
        if (!empty($data)) {

            $this->data = $data;
            $sendRequest = $this->sendRequest(array(
                'method' => 'POST',
                'sendRequestUrl' => 'images/watermark',
                'data' => $this->data,
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }


}

?>