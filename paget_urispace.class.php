<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_abstractresource.class.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_simplehtmlrepresentation.class.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_resourcedescription.class.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_permanentredirect.class.php';
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
      $this->send_client_error(404, 'Not Found', 'The requested resource ' . $request->full_path . ' was not found on this server (empty description)');
    }
    
    if ( $this->_has_http_method($resource, $request->method) ) {
      $response = $resource->{$request->method}($this, $request);
      if ($response && method_exists($response, 'emit') ) {
        $response->emit();  
      }
    }
    else {
      $this->send_client_error(405, 'Method not allowed');
    }
  }


  function get_resource($request) {
    $path = $request->full_path;
    $uri = $request->uri;
    
    if (array_key_exists($path, $this->_redirects)) {
      return new PAGET_PermanentRedirect('http://' . $_SERVER["HTTP_HOST"] . $this->_redirects[$path]);
    }
    
    if (array_key_exists($path, $this->_files) && file_exists($this->_files[$path]) ) {
      readfile($this->_files[$path]);
      exit; 
    }

    if (array_key_exists($path, $this->_forms) && array_key_exists('uri', $request->data)) {
      $res = $this->get_abstract_resource($request->data['uri']);
      $desc = $this->get_description($res->get_best_description_uri());
      $form = $this->get_form($this->_forms[$path], $uri, $desc);
      return $form;
    }

    if ($this->is_ir($uri)) {
      $desc = $this->get_description($uri);
      if ($desc == null ) return null;
      if ($desc->is_valid()) return $desc;
    }
    else {
      $res = $this->get_abstract_resource($uri);
      $desc = $this->get_description($res->get_best_description_uri());
      if ($desc == null ) return null;
      if ($desc->is_valid()) return $res;
    }

    if ( preg_match('~^(.+)/$~', $uri, $m)) {
      $possible_resource = $this->get_resource($m[1]);
      if ( $possible_resource != null ) {
        return new PAGET_PermanentRedirect($m[1]);
      } 
    }

    return null;
  }
  
  function get_description($uri) {
    return new PAGET_ResourceDescription($uri); 
  }

  function get_abstract_resource($uri) {
    return new PAGET_AbstractResource($uri); 
  }
  
  function get_form($formname, $uri, &$desc) {
    return new PAGET_Form($uri, $desc);
  } 

  function send_ok($body, $content_type) {
    header("HTTP/1.1 200 OK");
    header('Content-type: ' . $content_type);
    echo($body);     
    exit;   
  }

  function send_not_found($request) {
    $this->send_client_error(404, 'Not Found', 'The requested resource ' . $request->resource_uri . ' was not found on this server');
  }

  function send_redirect($code, $message, $uri) {
    header("HTTP/1.1 $code $message"); 
    header("Location: $uri");
    exit;   
  }

  function send_client_error($code = 400, $message = 'Bad Request', $body = "400 Bad Request") {
    header("HTTP/1.1 $code $message");
    header('Content-type: text/plain');
    echo($body);     
    exit;   
  }

  function send_server_error($code = 500, $message = 'Server Error', $body = "500 Server Error") {
    header("HTTP/1.1 $code $message");
    header('Content-type: text/plain');
    echo($body);     
    exit;   
  }
  
  function add_redirect($from_path, $to_path) {
    $this->_redirects[$from_path] = $to_path;     
  }

  function add_file($path, $filename) {
    $this->_files[$path] = $_SERVER['DOCUMENT_ROOT'] . $filename;     
  }  

  function add_form($path, $formname) {
    $this->_forms[$path] = $formname;     
  }  
  
  function get_template(&$request) {
    if (array_key_exists($request->full_path, $this->_forms)) {
      return PAGET_DIR . 'templates' .  DIRECTORY_SEPARATOR . 'form.tmpl.html';
    }
    else {
      return PAGET_DIR . 'templates' .  DIRECTORY_SEPARATOR . 'plain.tmpl.html';
    }
  }
  
  function get_setting($setting_name) {
    return '';  
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

  function is_ir($uri) {
    return preg_match('~^(.+)\.(html|rdf|xml|turtle|json)$~', $uri) ? TRUE : FALSE;
  }

}



if(false === function_exists('lcfirst'))
{
    /**
     * Make a string's first character lowercase
     *
     * @param string $str
     * @return string the resulting string.
     */
    function lcfirst( $str ) {
        $str[0] = strtolower($str[0]);
        return (string)$str;
    }
}
