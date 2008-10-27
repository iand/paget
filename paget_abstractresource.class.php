<?php
class PAGET_AbstractResource {
  var $_uri;
  
  function __construct($uri) {
    $this->_uri = $uri;
  } 
  
  function get_uri() {
    return $this->_uri; 
  }
  
  function get() {
    $description_uri = $this->get_best_description_uri();
    if ($description_uri != null) {
      header("HTTP/1.1 303 See Other"); 
      header("Location: " . $description_uri);        
      exit;
    }
    else {
      header("HTTP/1.1 406 Not Acceptable"); 
      header("Content-Type: text/plain");       
      echo 'No acceptable representation can be found for resource';
      exit;       
    }
  }
  

  function get_best_description_uri() {
    return $this->get_description_uri($this->select_best_media_type()); 
  }
  
  function select_best_media_type() {
    $preferred_types = array('application/rdf+xml', 'text/html', 'application/xml', 'application/json', 'text/plain');
    
    foreach ($preferred_types as $type) {
      if ( preg_match("~" . preg_quote($type) . "~i", $_SERVER["HTTP_ACCEPT"]) ) {
        return $type;
      }
    }
    
    return $preferred_types[0];
  }
  
  
  function get_description_uri($media_type) {
    $extensions = array(
                          'application/rdf+xml' => 'rdf', 
                          'text/html' => 'html', 
                          'application/xml' => 'xml', 
                          'application/json' => 'json', 
                          'text/plain' => 'turtle',
                      );
    if (array_key_exists($media_type, $extensions) ) {
      return $this->_uri . '.' . $extensions[$media_type];   
    }
    else {
      return null;  
    }
  }
}
