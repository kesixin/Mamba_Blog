<?php

include_once 'BmobRestClient.class.php';

/**
 * BmobUser batch对象类
 * @author karvinchen
 * @license http://www.gnu.org/copyleft/lesser.html Distributed under the Lesser General Public License (LGPL)
 */
class BmobPush extends BmobRestClient
{

    public function __construct($class = '')
    {
        parent::__construct();
    }


    /**
     * 保存设备信息
     * @param  $data data
     */
    public function addInstallations($data)
    {
        if (!empty($data)) {
            //重设对象的属性
            $this->cleanData();         
            $sendRequest = $this->sendRequest(array(
                'method' => 'POST',
                'data' => $data,
                'sendRequestUrl' => 'installations',
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }

    /**
     * 更新设备信息
     * @param  $data data
     */
    public function updateInstallations($id, $data)
    {
        if (!empty($data)) {
            $sendRequest = $this->sendRequest(array(
                'method' => 'PUT',
                'data' => $data,
                'sendRequestUrl' => 'installations/' . $id,
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }


    /**
     * 推送
     * @param  $data data
     */
    public function push($data)
    {
        if (!empty($data)) {
            $sendRequest = $this->sendRequest(array(
                'method' => 'POST',
                'data' => $data,
                'sendRequestUrl' => 'push',
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }



}

?>