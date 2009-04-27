<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_request.class.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions.inc.php';

class PAGET_UriSpace {
  var $_redirects = array();
  var $_files = array();
  var $_forms = array();

  function __construct() {

  }

  function dispatch() {
    $request = new PAGET_Request();
    $resource = $this->get_resource($request);
    if ( $resource == null ) {
      $response = new PAGET_Response(404,'The requested resource ' . $request->full_path . ' was not found on this server', array(), $request);
    }
    else {    
      if ( $this->_has_http_method($resource, $request->method) ) {
        $response = $resource->{strtolower($request->method)}($this, $request);
      }
      else {
        $response = new PAGET_Response(405, 'The requested resource ' . $request->full_path . ' does not support method ' . $request->method, array(), $request);
      }
    }
    
    if (!$response || !method_exists($response, 'emit') ) {
      $response = new PAGET_Response(500, 'An internal error occurred', array(), $request);
    }
  
    $response->configure($resource, $request);
    $response->emit();  
  }


  function get_resource($request) {
    return null;
  }
  
  /**
   * Is the given method name a valid HTTP method and a method on the resource
   * @param Resource resource
   * @param str method
   * @return bool
   */
  function _has_http_method(&$resource, $method)
  {
    if ($method == 'head' || $method == 'get' || $method == 'put' || $method == 'post' || $method == 'delete') {
      return method_exists($resource, $method);
    }
    return FALSE;
  }


}
