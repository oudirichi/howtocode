<?php

namespace lib;

/**
* Route
*   Parse the params url to create the path in MVC
*
* TODO:
*   Refactor to make it like a real root with access
*   Use the methods to restrict root
*/
class Route 
{
    /**
     * URL of this Route
     * @var string
     */
    private $url;
    /**
     * Accepted HTTP methods for this route.
     *
     * @var string[]
     */
    
    private $methods = array('GET', 'POST');

    private $base;
    private $raw_url;
    
    function __construct($base)
    {
        $this->base=$base;
    }

    public function getRoute(){

    }

    
    public function setUrl($url)
    {
        $url = (string)$url;
        // make sure that the URL is suffixed with a forward slash
        if (substr($url, -1) !== '/') {
            $url .= '/';
        }
        $this->url = $url;
    }



    public function createRoute($params){
        $this->raw_url=$params;
        $redirect=false;

        if(!isset($params[$this->base]))
            $params[$this->base] = "";

        $params[$this->base]=$this->removeSlash($params[$this->base]);

        $out=explode('/',$params[$this->base]);
        unset($params[$this->base]);
        if(!empty($params)){
            $redirect=true;
            foreach ($params as $v) {
                $v=$this->removeSlash($v);
                $v=urlencode($v);
                $out[]=$v;
            }
        }

        $this->url=App::$_ROOT;
        $this->url.=implode("/", $out);

        if($redirect==true){
            header('Location:' . $this->url);
            die();

        }



        return $out;

    }

    public function getUrl()
    {
        return $this->url;
    }

    
    private function removeSlash($param){

        if (substr($param, -1) === '/') {
            $param = substr($param, 0, -1);
            return $param;
        }else{
            return $param;
        }
    }
        
}
