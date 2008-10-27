<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_abstractresource.class.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_simplehtmlrepresentation.class.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_resourcedescription.class.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paget_permanentredirect.class.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions.inc.php';

class PAGET_UriSpace {
  var $_redirects = array();
  var $_files = array();
  function __construct() {

  }

  function dispatch() {
    // 1. Does the request URI identify a document in the filesystem? serve with 200
    // 2. Does the request URI identify a description of some resource we know about? construct that document and serve with 200
    // 3. Does the request URI identify something that we have some metadata about? 303 to a description of that resource
    // 4. 404
    $request_uri = 'http://' . $_SERVER["SERVER_NAME"]. $_SERVER["REQUEST_URI"];
    $resource = $this->get_resource($request_uri);
    if ( $resource == null ) {
      $this->send_client_error(404, 'Not Found', 'The requested resource ' . $request_uri . ' was not found on this server (empty description)');
    }
    
    $resource->get();
  }


  function get_resource($uri) {
    $path = parse_url($uri, PHP_URL_PATH);
    if (array_key_exists($path, $this->_redirects)) {
      return new PAGET_PermanentRedirect('http://' . $_SERVER["HTTP_HOST"] . $this->_redirects[$path]);
    }
    
    if (array_key_exists($path, $this->_files) && file_exists($this->_files[$path]) ) {
      readfile($this->_files[$path]);
      exit; 
    }
    
    if (preg_match('~^(.+)\.(html|rdf|xml|turtle|json)$~', $uri)) {
      $desc = $this->get_description($uri);
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
