<?php

include_once 'BmobRestClient.class.php';

/**
 * BmobObject object对象类
 * @author karvinchen 
 * @license http://www.gnu.org/copyleft/lesser.html Distributed under the Lesser General Public License (LGPL)
 */
class BmobObject extends BmobRestClient
{

    public $_includes = array();
    private $_className = '';

    public function __construct($class = '')
    {
        if ($class != '') {
            $this->_className = $class;
        } else {
            $this->throwError('创建对象时请包含对象id');
        }
        parent::__construct();
    }

    public function getRequestUrl($id=""){
        $className = $this->_className;
        if( "_User" == $className ){
            $className = "users";
        } elseif ( "_Installation" == $className ) {
            $className = "installations";
        } 
        if( $id ){
            if ( $this->_className!="_User" && $this->_className!="_Installation") {
                return 'classes/' . $className . '/' . $id;
            }else{
                return $className . '/' . $id;
            }
        } else {
            if ( $this->_className!="_User" && $this->_className!="_Installation") {
                return 'classes/' . $className ;
            }else{
                return $className ;
            }
        }
        
    }

    /**
     * 添加对象
     * @param  array $data 对象的属性数组
     *
     */
    public function create($data = array())
    {
        //重设对象的属性
        $this->setData($data);

        if (count($this->data) > 0 && $this->_className != '') {
            $sendRequest = $this->sendRequest(array(
                'method' => 'POST',
                'sendRequestUrl' => $this->getRequestUrl(""),
                'data' => $this->data,
            ));
            return $sendRequest;
        } else {
            $this->throwError('创建对象时请添加对象数据或指定对象id');
        }

    }

    /**
     * 获取对象
     * @param string $id 对象id, 当为空时表示获取所有对象
     * @param array $condition ，查询条件
     */
    public function get($id = "", $condition = array())
    {
        if ($this->_className != '') {
            if ($id) {
                $sendRequest = $this->sendRequest(array(
                    'method' => 'GET',
                    'sendRequestUrl' => $this->getRequestUrl($id),
                    'condition' => $condition,
                ));
            } else {
                $sendRequest = $this->sendRequest(array(
                    'method' => 'GET',
                    'sendRequestUrl' => $this->getRequestUrl(""),
                    'condition' => $condition,
                ));
            }

            return $sendRequest;
        } else {
            $this->throwError('获取对象时请指定对象id');
        }
    }


    /**
     * 更新对象的属性
     * @param string $id 对象id
     * @param  array $data 对象的属性数组
     */
    public function update($id, $data = array())
    {

        if ($this->_className != '' || !empty($id)) {

            if ($data) {
                //添加对象的属性
                $this->setData($data);
            } else {
                $this->throwError('请指定要更新的属性');
            }

            $sendRequest = $this->sendRequest(array(
                'method' => 'PUT',
                'sendRequestUrl' => $this->getRequestUrl($id),
                'data' => $this->data,
            ));

            return $sendRequest;

        } else {
            $this->throwError('修改对象时请指定对象id');
        }
    }

    /**
     * 删除对象
     * @param string $id 对象id
     */
    public function delete($id)
    {
        if ($this->_className != '' || !empty($id)) {
            $sendRequest = $this->sendRequest(array(
                'method' => 'DELETE',
                'sendRequestUrl' => $this->getRequestUrl($id),
            ));

            return $sendRequest;
        } else {
            $this->throwError('删除对象时请指定对象id');
        }
    }

    /**
     * 任何数字字段进行原子增加或减少的功能
     * @param string $id 对象id
     * @param string $field 需要修改的数字字段
     * @param int $amount 不加负号表示增加, 加负号表示减少
     */
    public function increment($id, $field, $amount)
    {
        //重设对象的属性
        $this->cleanData();
        if ($this->_className != '' || !empty($id)) {

            $this->data[$field] = $this->dataType('increment', $amount);

            $sendRequest = $this->sendRequest(array(
                'method' => 'PUT',
                'sendRequestUrl' => $this->getRequestUrl($id),
                'data' => $this->data,
            ));

            return $sendRequest;

        } else {
            $this->throwError('修改对象时请指定对象id');
        }

    }

    /**
     * 在一个对象中删除一个字段
     * @param string $id 对象id
     * @param string $field 需要删除的字段
     */
    public function deleteField($id, $field)
    {
        //重设对象的属性
        $this->cleanData();
        if ($this->_className != '' && !empty($id) && !empty($field)) {

            $this->data[$field] = $this->dataType('deleteField', $field);

            $sendRequest = $this->sendRequest(array(
                'method' => 'PUT',
                'sendRequestUrl' => $this->getRequestUrl($id),
                'data' => $this->data,
            ));

            return $sendRequest;

        } else {
            $this->throwError('修改对象时请指定对象id');
        }

    }

    /**
     * 添加数组数据
     * @param string $field 需要修改的字段
     * @param string $data 添加的数组
     */
    public function addArray($field, $data)
    {
        //重设对象的属性
        $this->cleanData();
        if ($this->_className != '' && !empty($field) && !empty($data)) {

            $this->data[$field] = $this->dataType('addArray', $data);

            $sendRequest = $this->sendRequest(array(
                'method' => 'POST',
                'sendRequestUrl' => $this->getRequestUrl(""),
                'data' => $this->data,
            ));

            return $sendRequest;

        } else {
            $this->throwError('添加对象时请指定对象field或数据');
        }

    }

    /**
     * 修改数组数据
     * @param string $id id
     * @param string $field 需要修改的字段
     * @param string $data 修改的数组
     */
    public function updateArray($id, $field, $data)
    {
        //重设对象的属性
        $this->cleanData();
        if ($this->_className != '' && !empty($id) && !empty($field) && !empty($data)) {

            $this->data[$field] = $this->dataType('addArray', $data);

            $sendRequest = $this->sendRequest(array(
                'method' => 'PUT',
                'sendRequestUrl' => $this->getRequestUrl($id),
                'data' => $this->data,
            ));

            return $sendRequest;

        } else {
            $this->throwError('修改对象时请指定对象id和field和数据');
        }

    }

    /**
     * 删除数组数据
     * @param string $id id
     * @param string $field 需要修改的字段
     * @param string $data 删除的数组
     */
    public function deleteArray($id, $field, $data)
    {
        //重设对象的属性
        $this->cleanData();
        if ($this->_className != '' && !empty($id) && !empty($field) && !empty($data)) {

            $this->data[$field] = $this->dataType('delArray', $data);

            $sendRequest = $this->sendRequest(array(
                'method' => 'PUT',
                'sendRequestUrl' => $this->getRequestUrl($id),
                'data' => $this->data,
            ));

            return $sendRequest;

        } else {
            $this->throwError('删除时请指定对象id和field和数据');
        }
    }

    /**
     * 添加关联对象（１对１）
     * @param string $field 需要添加关联的字段
     * @param string $otherObject 需要修改的字段
     * @param string $otherObjectId 删除的数组
     */
    public function addRelPointer($data)
    {
        //重设对象的属性
        $this->cleanData();
        if ($this->_className != '' && !empty($data) ) {
            $this->data = $this->dataType('addRelPointer', $data);

            $sendRequest = $this->sendRequest(array(
                'method' => 'POST',
                'sendRequestUrl' => $this->getRequestUrl(""),
                'data' => $this->data,
            ));

            return $sendRequest;

        } else {
            $this->throwError('添加关联对象时请指定对象id和field和数据');
        }
    }

    /**
     * 添加关联对象（１对多）
     * @param string $field 需要添加关联的字段
     * @param array $data 关联的数据
     */
    public function addRelRelation($field, $data)
    {
        //重设对象的属性
        $this->cleanData();
        if ($this->_className != '' && !empty($field) && !empty($data)) {

            $this->data[$field] = $this->dataType('addRelRelation', $data);

            $sendRequest = $this->sendRequest(array(
                'method' => 'POST',
                'sendRequestUrl' => $this->getRequestUrl(""),
                'data' => $this->data,
            ));

            return $sendRequest;

        } else {
            $this->throwError('添加关联对象时请指定对象id和data');
        }
    }

    /**
     * 修改关联对象（１对１）
     * @param string $id id
     * @param string $field 需要添加关联的字段
     * @param string $otherObject 需要修改的字段
     * @param string $otherObjectId 删除的数组
     */
    public function updateRelPointer($id, $field, $otherObject, $otherObjectId)
    {
        //重设对象的属性
        $this->cleanData();
        if ($this->_className != '' && !empty($field) && !empty($otherObject) && !empty($otherObjectId)) {

            $this->data[$field] = $this->dataType('updateRelPointer', array($field, $otherObject, $otherObjectId));

            $sendRequest = $this->sendRequest(array(
                'method' => 'PUT',
                'sendRequestUrl' => $this->getRequestUrl($id),
                'data' => $this->data,
            ));

            return $sendRequest;

        } else {
            $this->throwError('修改关联对象时请指定对象id和field和数据');
        }
    }

    /**
     * 修改关联对象（１对多）
     * @param string $id
     * @param string $field 需要添加关联的字段
     * @param array $data 关联的数据
     */
    public function updateRelRelation($id, $field, $data)
    {
        //重设对象的属性
        $this->cleanData();
        if ($this->_className != '' && !empty($id) && !empty($field) && !empty($data)) {

            $this->data[$field] = $this->dataType('addRelRelation', $data);

            $sendRequest = $this->sendRequest(array(
                'method' => 'PUT',
                'sendRequestUrl' => $this->getRequestUrl($id),
                'data' => $this->data,
            ));

            return $sendRequest;

        } else {
            $this->throwError('修改关联对象时请指定对象id和field和data');
        }
    }

    /**
     * 删除关联对象
     * @param string $id
     * @param string $field 需要添加关联的字段
     * @param array $data 关联的数据
     */
    public function deleteRelation($id, $field, $data)
    {
        //重设对象的属性
        $this->cleanData();
        if ($this->_className != '' && !empty($id) && !empty($field) && !empty($data)) {

            $this->data[$field] = $this->dataType('removeRelation', $data);

            $sendRequest = $this->sendRequest(array(
                'method' => 'PUT',
                'sendRequestUrl' => $this->getRequestUrl($id),
                'data' => $this->data,
            ));

            return $sendRequest;

        } else {
            $this->throwError('删除关联对象时请指定对象id和field和data');
        }
    }




}

?>