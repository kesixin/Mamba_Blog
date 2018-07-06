<?php

include_once 'BmobRestClient.class.php';

/**
 * BmobUser batch对象类
 * @author karvinchen
 * @license http://www.gnu.org/copyleft/lesser.html Distributed under the Lesser General Public License (LGPL)
 */
class BmobSchemas extends BmobRestClient
{

    public function __construct($class = '')
    {
        parent::__construct();
    }



    /**
     * 获取Schemas的信息
     * @param  $masterKey Master-Key
     * @param  $schemaName schemaName的名称
     * @param  $data
     */
    public function getSchemas($masterKey, $schemaName="")
    {
        if (!empty($masterKey)) {
            $url="";
            if( $schemaName ) {
                $url="schemas/" . $schemaName;
            } else {
                $url= "schemas" ;
            }
            $sendRequest = $this->sendRequest(array(
                'X-Bmob-Master-Key' => $masterKey,
                'method' => 'GET',
                'sendRequestUrl' => $url,
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }


    /**
     * create Schemas
     * @param  $masterKey Master-Key
     * @param  $schemaName schemaName的名称
     * @param  $data
     */
    public function createSchemas($masterKey, $schemaName, $data)
    {
        if (!empty($masterKey) && !empty($schemaName) && !empty($data)) {

            $sendRequest = $this->sendRequest(array(
                'X-Bmob-Master-Key' => $masterKey,
                'method' => 'POST',
                'data' => $data,
                'sendRequestUrl' => "schemas/" . $schemaName,
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }

    /**
     * update Schemas
     * @param  $masterKey Master-Key
     * @param  $schemaName schemaName的名称
     * @param  $data
     */
    public function updateSchemas($masterKey, $schemaName, $data)
    {
        if (!empty($masterKey) && !empty($schemaName) && !empty($data)) {

            $sendRequest = $this->sendRequest(array(
                'X-Bmob-Master-Key' => $masterKey,
                'method' => 'PUT',
                'data' => $data,
                'sendRequestUrl' => "schemas/" . $schemaName,
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }

    /**
     * delete Schemas
     * @param  $masterKey Master-Key
     * @param  $schemaName schemaName的名称
     */
    public function deleteSchemas($masterKey, $schemaName)
    {
        if (!empty($masterKey) && !empty($schemaName)) {

            $sendRequest = $this->sendRequest(array(
                'X-Bmob-Master-Key' => $masterKey,
                'method' => 'DELETE',
                'sendRequestUrl' => "schemas/" . $schemaName,
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }


}

?>