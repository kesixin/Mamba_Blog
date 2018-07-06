<?php

include_once 'BmobRestClient.class.php';

/**
 * BmobUser batch对象类
 * @author karvinchen
 * @license http://www.gnu.org/copyleft/lesser.html Distributed under the Lesser General Public License (LGPL)
 */
class BmobFile extends BmobRestClient
{

    public function __construct($class = '')
    {
        parent::__construct();
    }



    /**
     * 删除文件
     * @param array $data 删除文件的数据
     */
    public function delete($url)
    {
        if (!empty($url) ) {
            //重设对象的属性
            $this->cleanData();
            $sendRequest = $this->sendRequest(array(
                'method' => 'DELETE',
                'sendRequestUrl' => 'files/' . $url,
            ));
            return $sendRequest;
        } else {
            $this->throwError('请输入url');
        }
    }

    /**
     * 用CDN上传文件
     如果需要上传大文件,请在代码中调整php的配置:
    ini_set('max_execution_time', 30); //每个PHP页面运行的最大时间值(秒)，默认30秒
    ini_set('max_input_time', 60); //每个PHP页面接收数据所需的最大时间，默认60秒
    ini_set('memory_limit', '8m'); //每个PHP页面所吃掉的最大内存，默认8M
    ini_set('upload_max_filesize', '2m'); //即允许上传文件大小的最大值。默认为2M
    ini_set('post_max_size', '8m'); //指通过表单POST给PHP的所能接收的最大值，包括表单里的所有值。默认为8M
     * @param array $data 批量操作的数据
     */
    public function uploadFile2($fileName, $filePath)
    {
        if (!empty($fileName) && !empty($filePath)) {
            //重设对象的属性
            $this->cleanData();
            $this->data = file_get_contents($filePath);
            $sendRequest = $this->sendRequest(array(
                'method' => 'POST',
                'sendRequestUrl' => 'files/' . $fileName,
                'data' => $this->data,
            ), 2);
            return $sendRequest;
        } else {
            $this->throwError('请输入文件名和文件路径');
        }
    }    


     /**
     * 用uploadFile2接口上传的文件只能用这个接口删除文件
     * @param array $url
     */
    public function delete2($cdn, $url)
    {
        if (!empty($url) && !empty($cdn) ) {
            //重设对象的属性
            $this->cleanData();

            // $path = pathinfo($url);  
            // if( !$path ){
            //     $this->throwError('解析url错误, 正确的url是类似于:http://bmob-cdn-10.b0.upaiyun.com/2017/02/08/f39178e3409990ca80e0d9d60ecef768.png');
            // }
            if(strpos($url, "http://")>=0) {
                $url = trim($url, "http://");
            } else {
                $url = trim($url, "https://");
            }
            $url = substr($url, strpos($url, "/") + 1);

            $sendRequest = $this->sendRequest(array(
                'method' => 'DELETE',
                'sendRequestUrl' => 'files/' .$cdn."/". $url,
            ), 2 );

            
            return $sendRequest;
        } else {
            $this->throwError('请输入url');
        }
    }   
}

?>
