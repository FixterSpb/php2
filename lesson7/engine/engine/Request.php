<?php


namespace app\engine;


class Request
{

    protected $requestString;
    protected $controllerName;
    protected $actionName;
    protected $params;
    protected $method;


    public function __construct()
    {
        $this->requestString = $_SERVER['REQUEST_URI'];
        $this->parseRequest();
    }

    protected function parseRequest(){
        $this->method = $_SERVER['REQUEST_METHOD'];

        $url=explode('/', explode('?', $this->requestString)[0]);
        $this->controllerName = array_get($url, 1);
        $this->actionName = array_get($url, 2);

        $this->params = $_REQUEST;

        $data = json_decode(file_get_contents('php://input'));
        if (!is_null($data)) {
            foreach ($data as $key => $value) {
                $this->params[$key] = $value;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * @return mixed
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    public function getReferer(){
        return $_SERVER['HTTP_REFERER'];
    }

}