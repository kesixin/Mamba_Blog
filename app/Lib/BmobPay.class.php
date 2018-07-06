<?php

include_once 'BmobRestClient.class.php';

/**
 * BmobPay 支付类
 * @author karvinchen
 * @license http://www.gnu.org/copyleft/lesser.html Distributed under the Lesser General Public License (LGPL)
 */
class BmobPay extends BmobRestClient
{

    public function __construct($class = '')
    {
        parent::__construct();
    }


    /**
     * 查询订单
     * @param  $id
     */
    public function getOrder($id)
    {
        if (!empty($id)) {
            $sendRequest = $this->sendRequest(array(
                'method' => 'GET',
                'sendRequestUrl' => 'pay/' . $id,
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }

    /**
     * 支付扫码接口
     * @param  $orderPrice  价格
     * @param  $productName 商品名称
     * @param  $body     商品描述
     * @param  $payment  2:微信 3.qq  
     */
    public function webPay($orderPrice, $productName, $body, $payment)
    {
        if (!empty($orderPrice) && !empty($productName) && !empty($body)  ) {
            $this->cleanData();
            $sendRequest = $this->sendRequest(array(
                'method' => 'POST',
                'sendRequestUrl' => 'pay' ,
                'data' => array("order_price"=>$orderPrice, "product_name"=>$productName, "body"=>$body, "payment"=>$payment),
            ));
            return $sendRequest;
        } else {
            $this->throwError('参数不能为空');
        }
    }


}

?>