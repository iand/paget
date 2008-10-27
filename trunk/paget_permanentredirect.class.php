<?php


class PAGET_PermanentRedirect {
  var $_uri;
  
  function __construct($uri) {
    $this->_uri = $uri;
  } 
  
  function get() {
    header("HTTP/1.1 302 Found"); 
    header("Location: " . $this->_uri);
    exit;       
  }
}
