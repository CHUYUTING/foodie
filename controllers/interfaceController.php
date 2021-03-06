<?php

class interfaceController
{
    private $request, $response, $view, $data;

    function __construct($data)
    {
        //initializing value
        $this->data = $data;
        $this->request = $data->request;
        $this->response = $data->response;
        $this->view = $data->view;
    }

    function run($args = "")
    {
        //店家
        if($args['kind'] == "shop") {
            $this->shop($args);
        }
    }

    private function shop($args = ""){
        $db = getDB();

        switch ($args['action']) {
            case Action::SHOW:

                //取得外來變數
                $shop_id = isset($args['value'])?$args['value']:'';

                //初始化
                $menus = array();

                $result_menu = $db->select("menus","*",["shop_id"=>$shop_id]);
                $result_shop = $db->select("shops","*",["shop_id"=>$shop_id]);
                $result_shop[0]['menu'] = $result_menu;

                echo json_encode($result_shop);
                break;

            case Action::PAGE:
                $page = isset($args['value'])?$args['value']:'';
                $count = 12;
                $offset = $count * $page;
                $result = $db->select("shops",["id","shop_id","name_ch","name_en","tags","phone","address","image"],["LIMIT" => [$offset,$count]]);
                echo json_encode($result);
                break;
        }
    }
}