<?php

include_once 'BmobRestClient.class.php';

/**
 * BmobObject object对象类
 * @author karvinchen
 * @license http://www.gnu.org/copyleft/lesser.html Distributed under the Lesser General Public License (LGPL)
 */
class BmobCloudCode extends BmobRestClient
{

    private $_cloudCodeName = '';

    public function __construct($codeName = '')
    {
        if ($codeName != '') {
            $this->_cloudCodeName = $codeName;
        } else {
            $this->throwError('创建对象时请包含对象id');
        }
        parent::__construct();
    }

    /**
     * 获取对象
     * @param array $condition ，查询条件
     */
    public function get($data = array())
    {
        if ($this->_cloudCodeName != '') {

            $sendRequest = $this->sendRequest(array(
                'method' => 'POST',
                'sendRequestUrl' => 'functions/' . $this->_cloudCodeName,
                'data' => $data,
            ));

            return $sendRequest;
        } else {
            $this->throwError('获取对象时请指定对象id');
        }
    }


}