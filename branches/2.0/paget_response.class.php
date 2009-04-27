<?php

// Some code based on Tonic http://tonic.sourceforge.net/
class PAGET_Response {
  var $status_code;
  var $headers = array();
  var $body;
  var $request;
  
  var $messages = array(
    200 => 'OK',
    201 => 'Created',
    204 => 'No Content',
    301 => 'Moved Permanently',
    302 => 'Found',
    303 => 'See Other',
    304 => 'Not Modified',
    307 => 'Temporary Redirect',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    415 => 'Unsupported Media Type',
    500 => 'Internal Server Error'
  );
    
  function __construct($status_code = 200, $body = NULL, $headers = array(), $request = NULL) {
    $this->status_code = $status_code;
    $this->headers = $headers;
    $this->body = $body;
    $this->request = $request;
  }
  
  function set_body($body) {
    $this->body = $body;  
  }

  function configure(&$resource, &$request) {
    if ($request->encoding && $this->body) {
      //$this->headers['Content-Type'] = $resource->_media_type.'; charset=UTF-8';
      //$this->encode_content($request->encoding);
    }
    $this->headers['Content-Length'] = strlen($this->body);
  }


  function emit() { 

    header('HTTP/1.0 '.$this->status_code.' '.$this->get_status_message());
    foreach ($this->headers as $header => $value) {
      header($header.': '.$value);
    }
    if ($this->body) {
      echo $this->body;
    }
  }

  function get_status_message() {
    return isset($this->messages[$this->status_code]) ? $this->messages[$this->status_code] : 'Unknown';
  }
  
  /**
   * Add content encoding headers and encode the response body
   * @param str[] encodings The acceptable encodings
   */
  function encode_content($encodings) {
    if (ini_get('zlib.output_compression') == 0) { // do nothing if PHP will do the compression for us
      foreach ($encodings as $encoding) {
        switch($encoding) {
        case 'gzip':
          $this->headers['Content-Encoding'] = 'gzip';
          $this->body = gzencode($this->body);
          return;
        case 'deflate':
          $this->headers['Content-Encoding'] = 'deflate';
          $this->body = gzdeflate($this->body);
          return;
        case 'compress':
          $this->headers['Content-Encoding'] = 'compress';
          $this->body = gzcompress($this->body);
          return;
        case 'identity':
          return;
        }
      }
    }
  } 

}
