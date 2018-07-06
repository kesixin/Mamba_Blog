<?php

include_once 'BmobRestClient.class.php';

/**
 * BmobUser batch对象类
 * @author karvinchen
 * @license http://www.gnu.org/copyleft/lesser.html Distributed under the Lesser General Public License (LGPL)
 */
class BmobBatch extends BmobRestClient
{

    public function __construct($class = '')
    {
        parent::__construct();
    }


    /**
     * 批量操作
     * @param array $data 批量操作的数据
     */
    public function batch($data)
    {
        if (!empty($data)) {
            //重设对象的属性
            $this->cleanData();
            $this->data["requests"] = $data;
            $sendRequest = $this->sendRequest(array(
                'method' => 'POST',
                'sendRequestUrl' => 'batch',
                'data' => $this->data,
            ));
            return $sendRequest;
        } else {
            $this->throwError('批量操作时请指定操作的数据');
        }
    }


}

?>