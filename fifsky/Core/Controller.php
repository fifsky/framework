<?php namespace fifsky\Core;
/**
 * Created by PhpStorm.
 * User: 蔡旭东 caixudong@verystar.cn
 * Date: 15/2/16 下午4:18
 */

class Controller {

    /**
     * @return Request
     */
    public function request() {
        return request();
    }

    /**
     * @return Response
     */
    public function response() {
        return response();
    }

    public function __call($fun, $arg) {
        throw new Exception($fun . 'Action method not found file in: ' . $this->request()->getControllerName() . 'Controller', Exception::ERR_NOTFOUND_ACTION);
    }

    /**
     * @param $model
     *
     * @return object
     */
    protected function model($model) {
        return model($model);
    }

    /**
     * @return View
     */
    protected function view() {
        return view();
    }

    /**
     * 请求转发
     *
     * @param $controller
     * @param $action
     */
    protected function forward($controller, $action) {
        $params = func_get_args();

        if (count($params) >1 ) {
            $this->request()->setControllerName($params[0]);
            $this->request()->setActionName($params[1]);

        } else {
            $this->request()->setControllerName('error');
            $this->request()->setActionName('error');
        }

        $loader = app('loader');
        $controller_instance  = call_user_func_array([$loader,'controller'],array_splice($params,2));
        $controller_instance->{$action.'Action'}();
    }
}