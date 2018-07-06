<?php
include_once 'BmobConfig.class.php';
include_once 'BmobException.class.php';

/**
 * BmobRestClient 主类，所有的api请求都需要使用这个类
 * @author karvinchen
 * @license http://www.gnu.org/copyleft/lesser.html Distributed under the Lesser General Public License (LGPL)
 */
class BmobRestClient
{

    private $_bmobAppid = '';
    private $_bmobRestkey = '';
    private $_bmobUrl = '';
    private $_bmobUrlTwo = '';

    public $data;
    public $sendRequestUrl = '';
    public $responseData = '';
    public $masterKey = '';


    protected function __construct()
    {
        $this->_bmobAppid = BmobConfig::APPID;
        $this->_bmobRestkey = BmobConfig::RESTKEY;
        $this->_bmobUrl = BmobConfig::BMOBURL;
        $this->_bmobUrlTwo = BmobConfig::BMOBURLTWO;

        if (empty($this->_bmobAppid) || empty($this->_bmobRestkey)) {
            $this->throwError('必须要设置Application ID 和 REST API Key');
        }

        if (!$this->_bmobUrlTwo) {
            $this->throwError('必须要在BmobConfig.class.php中设置BMOBURLTWO的值, 请参考github上的设置');
        }       

        $version = curl_version();

        if (!$version['features'] & CURL_VERSION_SSL) {
            $this->throwError('不支持ssl的链接');
        }

    }

    /**
     * 重设对象的属性
     * @param array $data
     */
    public function setData($data = array())
    {

        //每次使用前先清空对象属性数组
        $this->data = array();
        if ($data) {
            foreach ($data as $name => $value) {
                if ($name != '_className') {
                    $this->data[$name] = $value;
                }
            }
        }

    }

    /**
     * 设置master key
     * @param string $masterKey
     */
    public function setMasterkey($masterKey){
        $this->masterKey = $masterKey;
    } 

    /**
     * 重设对象的属性
     * @param array $data
     */
    public function cleanData()
    {

        //每次使用前先清空对象属性数组
        $this->data = array();

    }


    /**
     * 所有的请求都通过这个方法发送
     * @param  $args
     */
    protected function sendRequest($args, $apiVersion = 1)
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_TIMEOUT, 30);
        curl_setopt($c, CURLOPT_USERAGENT, 'bmob-php-library/1.0');
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLINFO_HEADER_OUT, true);
        curl_setopt($c, CURLOPT_CUSTOMREQUEST, $args['method']);
        //支持SSL
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);

        if( 2 == $apiVersion ){
            $url = $this->_bmobUrlTwo . $args['sendRequestUrl'];
        } else {
            $url = $this->_bmobUrl . $args['sendRequestUrl'];
        }

        //Users的方法
        $header = array(
                    'Content-Type: application/json',
                    'X-Bmob-SDK-Type: php',
                    'X-bmob-Application-Id: ' . $this->_bmobAppid,
                    'X-bmob-REST-API-Key: ' . $this->_bmobRestkey,
                  );
        if (substr($args['sendRequestUrl'], 0, 5) == 'users') {
            if (isset($args['sessionToken'])) {
                //需要传入token, 用于更新删除的操作
                array_push($header, 'X-Bmob-Session-Token:'.$args['sessionToken']);
            } elseif (isset($args['masterKey'])) {
                //需要传入X-Bmob-Master-Key   
                array_push($header, 'X-Bmob-Master-Key:'.$args['masterKey']);           
            } else {

            }
        } elseif (substr($args['sendRequestUrl'], 0, 7) == 'classes') {
            
        } elseif (strpos($args['sendRequestUrl'], "updateUserPassword") !== false) {
            //对象的方法
           array_push($header, 'X-Bmob-Session-Token:'.$args['sessionToken']);
        } elseif (strpos($args['sendRequestUrl'], "roles") !== false && $args['method'] == "DELETE") {
            //对象的方法
           array_push($header, 'X-Bmob-Session-Token:'.$args['sessionToken']);
        } elseif (strpos($args['sendRequestUrl'], "apps") !== false) {
            //对象的方法

        } elseif (strpos($args['sendRequestUrl'], "schemas") !== false) {
            //对象的方法

        } else {

        }

        if( $this->masterKey ){
             array_push($header, 'X-Bmob-Master-Key:'.$this->masterKey);        
        }
        curl_setopt($c, CURLOPT_HTTPHEADER, $header);

        // var_dump($url);
        // print_r($header);

        //生成post data
        if ($args['method'] == 'PUT' || $args['method'] == 'POST') {
            $postData = $args['data'];
            if (strpos($args['sendRequestUrl'], "files") === false || strpos($args['sendRequestUrl'], "files")>0) { //非上传文件的操作把body内容变为json
                $postData = json_encode($args['data']);
            }
             // echo "postdata:".$postData;
            curl_setopt($c, CURLOPT_POSTFIELDS, $postData);
        }

        //生成查询的条件
        if ($args['method'] == 'GET' && isset($args['condition']) && $args['condition']) {

            foreach ($args['condition'] as $con) {
                list($key, $value) = explode("=", $con);
                $args['urlParams'][$key] = $value;
            }

        }

        if ($args['sendRequestUrl'] == 'login') {
            $urlParams = http_build_query($args['data'], '', '&');
            $url = $url . '?' . $urlParams;
        }
        if (array_key_exists('urlParams', $args)) {

            if( $args['sendRequestUrl'] == "cloudQuery" ) {
                $url = $url . '?bql=' .urlencode($args['urlParams']['bql']);
                if( isset($args['urlParams']['values']) ) {
                    $url = $url . '&values=' .urlencode($args['urlParams']['values']);
                }
            }else {
                $urlParams = http_build_query($args['urlParams'], '', '&');
                $url = $url . '?' . $urlParams;
            }
        }

        curl_setopt($c, CURLOPT_URL, $url);
        $response = curl_exec($c);
        // echo "response_code:".$response;
        if (!$response) {
            trigger_error(curl_error($c));
        }

        $responseCode = curl_getinfo($c, CURLINFO_HTTP_CODE);
        curl_close($c);
        $expectedCode = array('200', '201');
        return $this->checkResponse($args,$response, $responseCode, $expectedCode);
    }

    /**
     * 生成特殊的数据类型
     * @param string $type
     * @param array $params
     */
    protected function dataType($type, $params)
    {
        if ($type != '') {
            switch ($type) {
                case 'date':
                    $return = array(
                        "__type" => "Date",
                        "iso" => date("c", strtotime($params))
                    );
                    break;
                case 'geopoint':
                    $return = array(
                        "__type" => "GeoPoint",
                        "latitude" => floatval($params[0]),
                        "longitude" => floatval($params[1])
                    );
                    break;
                case 'increment':
                    $return = array(
                        "__op" => "Increment",
                        "amount" => $params[0]
                    );
                    break;
                case 'deleteField':
                    $return = array(
                        "__op" => "Delete",
                    );
                    break;
                case 'addArray':
                    $return = array(
                        "__op" => "Add",
                        "objects" => $params,
                    );
                    break;
                case 'updateArray':
                    $return = array(
                        "__op" => "AddUnique",
                        "objects" => $params,
                    );
                    break;
                case 'delArray':
                    $return = array(
                        "__op" => "Remove",
                        "objects" => $params,
                    );
                    break;
                case 'addRelPointer':
                    $data = array();
                     
                    foreach ($params as $param) {

                        $key = $param[0];
                        $data[$key] = array(
                            "__type" => "Pointer",
                            "className" => $param[1],
                            "objectId" => $param[2],
                        );
                    }
                    return $data;
                    break;
                case 'updateRelPointer':
                   
                    return array(
                            "__type" => "Pointer",
                            "className" => $params[1],
                            "objectId" => $params[2],
                        );
                    
                    break;                     
                case 'addRelRelation':
                    $data = array();
                    foreach ($params as $param) {
                        $data[] = array(
                            "__type" => "Pointer",
                            "className" => $param[0],
                            "objectId" => $param[1],
                        );
                    }
                    $return = array(
                        "__op" => "AddRelation",
                        "objects" => $data,

                    );
                    break;
                case 'removeRelation':
                    $data = array();
                    foreach ($params as $param) {
                        $data[] = array(
                            "__type" => "Pointer",
                            "className" => $param[0],
                            "objectId" => $param[1],
                        );
                    }
                    $return = array(
                        "__op" => "RemoveRelation",
                        "objects" => $data,

                    );
                    break;
                default:
                    $return = false;
                    break;
            }

            return $return;
        }
    }

    /**
     * 抛出异常
     * @param $msg
     * @param $code
     */
    protected function throwError($msg, $code = 0)
    {
        throw new BmobException($msg, $code);
    }

    /**
     * 检查返回值
     * @param string $response
     * @param array $responseCode
     * @param array $expectedCode
     */
    private function checkResponse($args, $response, $responseCode, $expectedCode)
    {
        if (!in_array($responseCode, $expectedCode)) {
            $error = json_decode($response, true);
            $msg = isset($error['error']) ? $error['error'] : "";
            $code = isset($error['code']) ? $error['code'] : 0;
            $this->throwError($msg, $code);
        } else {
            //check for empty return
            if ($response == '{}') {
                return true;
            } else {
                $decodeResponse = json_decode($response);
                //把云端代码返回值从result中剥离出来
                if (isset($decodeResponse->result)) {
                    $tradeNo = "";
                    //订单接口，要把订单号返回
                    if("POST" == $args["method"] && "pay" == $args["sendRequestUrl"]) {
                        $tradeNo  = $decodeResponse->out_trade_no;
                    }
                    $decodeResponse = $decodeResponse->result;
                    if("POST" == $args["method"] && "pay" == $args["sendRequestUrl"]) {
                        $decodeResponse->tradeNo  = $tradeNo;
                    }                   

                }
                return $decodeResponse;
            }
        }
    }
}


?>