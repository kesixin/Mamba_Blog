<?php

include_once 'BmobRestClient.class.php';

/**
 * BmobUser User对象类
 * @author karvinchen
 * @license http://www.gnu.org/copyleft/lesser.html Distributed under the Lesser General Public License (LGPL)
 */
class BmobUser extends BmobRestClient
{

    public function __construct($class = '')
    {
        parent::__construct();
    }


    /**
     * 用户注册
     * @param array $data 需要传入的参数
     */
    public function register($data = array())
    {
        $this->cleanData();
        if (!empty($data)) {
            $request = $this->sendRequest(array(
                'method' => 'POST',
                'sendRequestUrl' => 'users',
                'data' => $data
            ));
            return $request;

        } else {
            $this->throwError('输入参数不能为空');
        }
    }

    /**
     * 用户登录, 其中username和password为必填字段
     * @param string $username 用户名, 必填
     * @param string $password 密码, 必填
     */
    public function login($username, $password)
    {
        if (!empty($username) || !empty($password)) {
            $request = $this->sendRequest(array(
                'method' => 'GET',
                'sendRequestUrl' => 'login',
                'data' => array(
                    'username' => $username,
                    'password' => $password
                )
            ));
            return $request;
        } else {
            $this->throwError('用户名和密码不能为空');
        }
    }

    /**
     * 用手机号登录, 其中mobilePhoneNumber和smsCode为必填字段
     * @param string $mobilePhoneNumber 手机号
     * @param string $smsCode 验证码
     */
    public function loginByMobile($mobilePhoneNumber, $smsCode)
    {
        if (!empty($mobilePhoneNumber) || !empty($smsCode)) {
            $request = $this->sendRequest(array(
                'method' => 'POST',
                'sendRequestUrl' => 'users',
                'data' => array(
                    'mobilePhoneNumber' => $mobilePhoneNumber,
                    'smsCode' => $smsCode
                )
            ));
            return $request;
        } else {
            $this->throwError('手机号和验证码不能为空');
        }
    }

    /**
     * 获取用户的信息
     * @param string $userId 用户id, 必填
     */
    public function get($userId = 0, $condition = array())
    {
        if ($userId) {

            //获取某个用户的信息
            $request = $this->sendRequest(array(
                'method' => 'GET',
                'sendRequestUrl' => 'users/' . $userId,
            ));
            return $request;
        } else {
            //获取所有用户的信息
            $request = $this->sendRequest(array(
                'method' => 'GET',
                'sendRequestUrl' => 'users',
                'condition' => $condition,
            ));
            return $request;
        }

    }

    /**
     * 更新用户的信息
     * @param string $userId 用户id, 必填
     * @param string $sessionToken 在用户登录或注册后获取, 必填
     * @param array $data 需要更新的用户属性
     */
    public function update($userId, $sessionToken, $data = array())
    {
        if (!empty($userId) || !empty($sessionToken)) {

            if ($data) {
                $request = $this->sendRequest(array(
                    'method' => 'PUT',
                    'sendRequestUrl' => 'users/' . $userId,
                    'sessionToken' => $sessionToken,
                    'data' => $data
                ));
            } else {
                $this->throwError('请输入需要更新的属性');
            }

            return $request;
        } else {
            $this->throwError('用户id和sessionToken不能为空');
        }

    }

    /**
     * 通过MasterKey更新用户的信息
     * @param string $userId 用户id, 必填
     * @param string $masterKey 后台应用密钥中的Master Key
     * @param array $data 需要更新的用户属性
     */
    public function updateByMasterKey($userId, $masterKey, $data = array())
    {
        if (!empty($userId) || !empty($masterKey)) {

            if ($data) {
                $request = $this->sendRequest(array(
                    'method' => 'PUT',
                    'sendRequestUrl' => 'users/' . $userId,
                    'masterKey' => $masterKey,
                    'data' => $data
                ));
            } else {
                $this->throwError('请输入需要更新的属性');
            }

            return $request;
        } else {
            $this->throwError('用户id和masterKey不能为空');
        }

    }    

    /**
     * 请求重设密码,前提是用户将email与他们的账户关联起来
     * @param string $email
     */
    public function requestPasswordReset($email)
    {
        if (!empty($email)) {
            $request = $this->sendRequest(array(
                'method' => 'POST',
                'sendRequestUrl' => 'requestPasswordReset',
                'data' => array("email" => $email)
            ));

            return $request;
        } else {
            $this->throwError('email is required for the requestPasswordReset method');
        }

    }

    /**
     * 删除用户
     * @param string $userId
     * @param string $sessionToken
     */
    public function delete($userId, $sessionToken)
    {
        if (!empty($userId) || !empty($sessionToken)) {
            $request = $this->sendRequest(array(
                'method' => 'DELETE',
                'sendRequestUrl' => 'users/' . $userId,
                'sessionToken' => $sessionToken
            ));

            return $request;
        } else {
            $this->throwError('用户id和sessionToken不能为空');
        }
    }

    /**
     * 删除用户
     * @param string $userId
     * @param string $masterKey 
     */
    public function deleteByMasterKey($userId, $masterKey)
    {
        if (!empty($userId) || !empty($masterKey)) {
            $request = $this->sendRequest(array(
                'method' => 'DELETE',
                'sendRequestUrl' => 'users/' . $userId,
                'masterKey' => $masterKey
            ));

            return $request;
        } else {
            $this->throwError('用户id和masterKey不能为空');
        }
    }

    /**
     * 使用短信验证码进行密码重置
     * @param string $oldPassword 旧密码
     * @param string $newPassword 新密码
     */
    public function resetPasswordBySmsCode($smsCode, $newPassword)
    {
        if (!empty($newPassword) || !empty($smsCode)) {
            $request = $this->sendRequest(array(
                'method' => 'PUT',
                'sendRequestUrl' => 'resetPasswordBySmsCode/' . $smsCode,
                'data' => array("password" => $newPassword)
            ));
            return $request;
        } else {
            $this->throwError('密码和短信验证码不能为空');
        }

    }

    /**
     * 用户输入一次旧密码做一次校验，旧密码正确才可以修改为新密码
     * @param string $userId id
     * @param string $sessionToken sessionToken
     * @param string $oldPassword 旧密码
     * @param string $newPassword 新密码
     */
    public function updateUserPassword($userId, $sessionToken, $oldPassword, $newPassword)
    {
        if (!empty($oldPassword) || !empty($newPassword) || !empty($userId) || !empty($sessionToken)) {
            $request = $this->sendRequest(array(
                'method' => 'PUT',
                'sendRequestUrl' => 'updateUserPassword/' . $userId,
                'sessionToken' => $sessionToken,
                'data' => array("oldPassword" => $oldPassword, "newPassword" => $newPassword)
            ));

            return $request;
        } else {
            $this->throwError('参数不能为空');
        }

    }

    /**
     * 请求验证Email
     * @param string $email email
     */
    public function requestEmailVerify($email)
    {
        if (!empty($email)) {
            $request = $this->sendRequest(array(
                'method' => 'POST',
                'sendRequestUrl' => 'requestEmailVerify',
                'data' => array("email" => $email)
            ));

            return $request;
        } else {
            $this->throwError('email不能为空');
        }

    }


}

?>