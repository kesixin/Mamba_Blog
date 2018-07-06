<?php

include_once 'BmobRestClient.class.php';

/**
 * BmobUser batch对象类
 * @author karvinchen
 * @license http://www.gnu.org/copyleft/lesser.html Distributed under the Lesser General Public License (LGPL)
 */
class BmobRole extends BmobRestClient
{

    public function __construct($class = '')
    {
        parent::__construct();
    }



    /**
     * 创建角色
     * @param array $data 参数
     */
    public function createRole($data)
    {
        if (!empty($data)) {
            //重设对象的属性
            $this->cleanData();
            $this->data = $data;
            $sendRequest = $this->sendRequest(array(
                'method' => 'POST',
                'sendRequestUrl' => 'roles',
                'data' => $this->data,
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }

    /**
     * 获取角色
     * @param  $id id
     */
    public function getRole($id)
    {
        if (!empty($id)) {

            $sendRequest = $this->sendRequest(array(
                'method' => 'GET',
                'sendRequestUrl' => 'roles/' . $id,
            ));
            return $sendRequest;
        } else {
            $this->throwError('id不能为空');
        }
    }

    /**
     * 更新角色
     * @param  $id id
     */
    public function updateRole($id, $field, $op, $data)
    {
        if (!empty($id) && !empty($field) && !empty($op) && !empty($data)) {

            $this->data[$field] = array("__op" => $op, "objects" => $data);
            $sendRequest = $this->sendRequest(array(
                'method' => 'PUT',
                'data' => $this->data,
                'sendRequestUrl' => 'roles/' . $id,
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }

    /**
     * 删除角色
     * @param  $id id
     * @param  $sessionToken sessionToken
     */
    public function deleteRole($id, $sessionToken)
    {
        if (!empty($id) && !empty($sessionToken)) {
            $sendRequest = $this->sendRequest(array(
                'method' => 'DELETE',
                'data' => $this->data,
                'sessionToken' => $sessionToken,
                'sendRequestUrl' => 'roles/' . $id,
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }


}

?>