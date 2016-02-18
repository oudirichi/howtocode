<?php 
/**
* 
*/
namespace lib\Router;
class Router
{
	private $url;
	private $routes = [];

	function __construct($url)
	{
		$this->url = $url;
	}

	/**
	 * [run searching root that match]
	 * @return [type] [return the callable]
	 */
	public function run(){
	    if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
	        throw new RouterException('REQUEST_METHOD does not exist');
	    }
	    foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
	        if($route->match($this->url)){
	            return $route->call();
	        }
	    }
	    throw new RouterException('No matching routes');
	}


	/* Ressources
   ========================================================================== */
   /**
    * [ressources create some http verbs]
    * @param  [type] $controller [description]
    * @return [type]             [description]
    */
	public function ressources($controller){
		return $this->get($controller, "/" . $controller . "#index");
		return $this->get($controller, "/:id" . $controller . "#show");
		return $this->get($controller, "/:id/edit" . $controller . "#edit");
		return $this->get($controller, "/create" . $controller . "#create");
		return $this->post($controller, "/make" . $controller . "#make");
		return $this->put($controller, "/:id" . $controller . "#update");
		return $this->delete($controller, "/:id" . $controller . "#destroy");

	}

	/* HTTP Verb
   ========================================================================== */

	public function get($path, $callable){
		return $this->add($path, $callable, "GET");
	}

	public function post($path, $callable){
		return $this->add($path, $callable, "POST");
	}

	public function delete($path, $callable){
		return $this->add($path, $callable, "DELETE");
	}

	public function put($path, $callable){
		return $this->add($path, $callable, "PUT");
	}


	private function add($path, $callable, $method){
		$route = new Route($path, $callable);
		$this->routes[$method][] = $route;
		return $route;
	}
}