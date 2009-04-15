<?php
require_once PAGET_DIR. "paget_request.class.php";

class FakeRequest extends PAGET_Request {
  function __construct($method, $uri)
  {
    $this->method = $method;
    list($this->full_path, $this->url) = $this->_get_url();
    $this->uri = $uri;
    $this->accept = '*/*';
    $this->language = array();
    $this->encoding = NULL;
    $this->mimetype = NULL;
    $this->body = NULL;
    $this->ifNoneMatch = array();
    $this->ifMatch = array();
    $this->ifModifiedSince = 0;
    $this->ifUnmodifiedSince = 0;
    $this->basicAuth = NULL;
    $this->digestAuth = NULL;
    $this->cookieAuth = NULL;
    $this->data = $_REQUEST;
  }
  
  
}

