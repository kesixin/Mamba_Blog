<?php

include_once 'BmobRestClient.class.php';

/**
 * BmobUser batch对象类
 * @author karvinchen
 * @license http://www.gnu.org/copyleft/lesser.html Distributed under the Lesser General Public License (LGPL)
 */
class BmobApp extends BmobRestClient
{

    public function __construct($class = '')
    {
        parent::__construct();
    }

    /**
     * 获取app的信息, 指定appId则获取某个app的信息
     * @param  $email 登录的用户名
     * @param  $password 登录的密码
     * @param  $appId
     */
    public function getApp($email, $password, $appId = 0)
    {
        if (!empty($email) && !empty($password)) {
            if ($appId != 0) {
                $requestUrl = 'apps/' . $appId;
            } else {
                $requestUrl = 'apps';
            }
            $sendRequest = $this->sendRequest(array(
                'X-Bmob-Email' => $email,
                'X-Bmob-Password' => $password,
                'method' => 'GET',
                'sendRequestUrl' => $requestUrl,
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }

    /**
     * 创建app
     * @param  $email 登录的用户名
     * @param  $password 登录的密码
     * @param  $data
     */
    public function createApp($email, $password, $data)
    {
        if (!empty($email) && !empty($password) && !empty($data)) {

            $sendRequest = $this->sendRequest(array(
                'X-Bmob-Email' => $email,
                'X-Bmob-Password' => $password,
                'method' => 'POST',
                'data' => $data,
                'sendRequestUrl' => "apps",
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }

    /**
     * 修改app的信息
     * @param  $email 登录的用户名
     * @param  $password 登录的密码
     * @param  $data
     */
    public function updateApp($email, $password, $id, $data)
    {
        if (!empty($email) && !empty($password) && !empty($id) && !empty($data)) {

            $sendRequest = $this->sendRequest(array(
                'X-Bmob-Email' => $email,
                'X-Bmob-Password' => $password,
                'method' => 'PUT',
                'data' => $data,
                'sendRequestUrl' => "apps/" . $id,
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }


}

?>