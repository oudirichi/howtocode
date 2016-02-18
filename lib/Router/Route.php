<?php 
/**
* 
*/

namespace lib\Router;
class Route
{
	private $path;
	private $callable;
	private $matches = [];
    private $params = [];
    

	public function __construct($path, $callable){
        $this->params['id'] = '[0-9]+';
        $this->params['slug'] = '[a-z\-0-9]+';

        $this->path = trim($path, '/');  // On retire les / inutils
        $this->callable = $callable;
    }

    /**
     * [with Adding regex to params]
     * @param  [type] $param [params written in route]
     * @param  [type] $regex [regex to add to this params]
     * @return [type]        [$this (Route)]
     */
    public function with($param, $regex){
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this; // On retourne tjrs l'objet pour enchainer les arguments
    }

    

    /**
    * Permettra de capturer l'url avec les paramètre 
    * get('/posts/:slug-:id') par exemple
    **/
    
    /**
     * [match verify if the url match defined routes]
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    public function match($url){

        // Supprimer les slash
        $url = trim($url, '/');

        // s'il y a un params (:....) appel paramMatch
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);

        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }

        array_shift($matches);
        $this->matches = $matches;  // On sauvegarde les paramètre dans l'instance pour plus tard
        return true;
    }

    // s'il y a des params, alors on les modifies ex :id
    private function paramMatch($match){

        // retourne le regex
        if(isset($this->params[$match[1]])){
            return '(' . $this->params[$match[1]] . ')';
        }
         // n'importe quoi qui n'est pas un /
        return '([^/]+)';
    }

	public function call(){

        if(is_callable($this->callable)){
            return call_user_func_array($this->callable, $this->matches);
        }else{

            $match = explode("#", $this->callable);
            $this->controller = $match[0]. "Controller";
            $this->action = $match[1];

            $filename = 'app/controllers/'.$this->controller.'.php';
            if (!file_exists($filename)){
                throw new RouterException("Controller: {$this->controller} can't be find");
            }
            require($filename);

            $controller = new $this->controller();
            if(method_exists($controller,$this->action)){

                call_user_func_array(array($controller,$this->action),$this->matches);
                //call_user_func_array($match,$this->matches);
            }

        }
	}
}