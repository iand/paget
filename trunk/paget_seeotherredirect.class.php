<?php


class PAGET_SeeOtherRedirect {
  var $_uri;
  var $_config;
  
  function __construct($uri, &$config) {
    $this->_uri = $uri;
    $this->_config = $config;
  } 
  
  function get() {
    header("HTTP/1.1 303 See Other"); 
    header("Location: " . $this->_uri);
    exit;       
  }
}
