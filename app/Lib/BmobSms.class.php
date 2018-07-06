<?php

include_once 'BmobRestClient.class.php';

/**
 * BmobUser batch对象类
 * @author karvinchen
 * @license http://www.gnu.org/copyleft/lesser.html Distributed under the Lesser General Public License (LGPL)
 */
class BmobSms extends BmobRestClient
{

    public function __construct($class = '')
    {
        parent::__construct();
    }



    /**
     * 发送短信
     * @param  $mobile    发送的手机号
     * @param  $content     短信的内容
     * @param  $sendTime    定时发送，比如未来的某一时刻给某个手机发送一条短信，sendTime的格式必须是YYYY-mm-dd HH:ii:ss， 如: 2015-05-26 12:13:14
     */
    public function sendSms($mobile, $content, $sendTime = "")
    {
        if (!empty($mobile) && !empty($content)) {
            $data = array("mobilePhoneNumber" => $mobile, "content" => $content);
            if ($sendTime != "") {
                $data["sendTime"] = $sendTime;
            }
            $sendRequest = $this->sendRequest(array(
                'method' => 'POST',
                'data' => $data,
                'sendRequestUrl' => 'requestSms',
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }

    /**
     * 发送短信验证码
     * @param  $mobile    发送的手机号
     */
    public function sendSmsVerifyCode($mobile, $template="")
    {
        if (!empty($mobile)) {
            if( $template ){
                $data = array("mobilePhoneNumber" => $mobile, "template"=>$template);
            } else {
                $data = array("mobilePhoneNumber" => $mobile);
            }
            $sendRequest = $this->sendRequest(array(
                'method' => 'POST',
                'data' => $data,
                'sendRequestUrl' => 'requestSmsCode',
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }

    /**
     * 验证短信验证码
     * @param  $mobile    发送的手机号
     * @param  $verifyCode  短信验证码
     */
    public function verifySmsCode($mobile, $verifyCode)
    {
        if (!empty($mobile) && !empty($verifyCode)) {
            $data = array("mobilePhoneNumber" => $mobile);
            $sendRequest = $this->sendRequest(array(
                'method' => 'POST',
                'data' => $data,
                'sendRequestUrl' => 'verifySmsCode/' . $verifyCode,
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }

    /**
     * 查询短信状态
     * @param  $smsId    请求短信验证码返回的smsId值
     */
    public function querySms($smsId)
    {
        if (!empty($smsId)) {
            $sendRequest = $this->sendRequest(array(
                'method' => 'GET',
                'sendRequestUrl' => 'querySms/' . $smsId,
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }


}

?>