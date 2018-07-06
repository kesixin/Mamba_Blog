<?php

include_once 'BmobRestClient.class.php';

/**
 * BmobUser batch对象类
 * @author karvinchen
 * @license http://www.gnu.org/copyleft/lesser.html Distributed under the Lesser General Public License (LGPL)
 */
class BmobTimestamp extends BmobRestClient
{

    public function __construct($class = '')
    {
        parent::__construct();
    }


    /**
     * 获取服务器时间
     */
    public function getTimestamp()
    {
        $sendRequest = $this->sendRequest(array(
            'method' => 'GET',
            'sendRequestUrl' => "timestamp",
        ));
        return $sendRequest;

    }


}

?>