<?php
namespace wwcms;

use Symfony\Component\HttpFoundation\Request;

class Router{
  private $controller;
  private $action;

  public function getController(){
    return $this->controller;
  }

  public function getAction(){
    return $this->action;
  }

  public function mapFromRequest(){

    $this->mapRequest();

    if ( !class_exists( $this->controller, true) ){
      throw( new \Exception( "Class <".$this->controller."> not found") );
    }
    $controller = $this->controller;
    $action = $this->action;

    $object = new $controller;
    if( !method_exists($object, $action) ){
      throw( new \Exception( "Method <".$this->controller."->".$this->action."> not implemented" ) );
    }
    return;
  }

  private function mapRequest(){
    $request = Request::createFromGlobals();
    $components = explode("/", $request->getPathInfo());
    $components = array_filter($components , 'strlen' );

    $controller = array_shift($components);
    $action = array_shift($components);
    $controller = !is_null( $controller ) ? $controller : "News";
    $this->controller = $controllerClass = "\\module\\".ucfirst( $controller )."\\".ucfirst( $controller );
    $this->action = !is_null( $action ) ? $action."Action": "ilsingoloAction";
    return;
  }

}
