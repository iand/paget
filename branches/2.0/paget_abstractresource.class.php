<?php
class PAGET_AbstractResource {
  var $_uri;
  
  function __construct($uri) {
    $this->_uri = $uri;
  } 
  
  function get_uri() {
    return $this->_uri; 
  }
  
  function get(&$urispace,&$request) {
    $extension = 'rdf';
    $accepts = $request->accept;
    foreach ($accepts as $accept) {
      if ($accept == 'application/rdf+xml') {
        break;          
      }
      else if ($accept == 'application/json') {
        $extension = 'json';
        break;          
      }
      else if ($accept == 'text/plain') {
        $extension = 'turtle';
        break;          
      }
      else if ($accept == 'text/html') {
        $extension = 'html';
        break;          
      }
    }

    $query = '';
    foreach ($request->data as $key => $value) {
      if (strlen($query) == 0) {
        $query = '?';
      }   
      else {
        $query .= '&';
      }
      $query .= urlencode($key) . '=' . urlencode($value);  
    }

    $desc_uri = $this->_uri . '.' . $extension . $query ;
    
    return new PAGET_Response(303, 'See ' . $desc_uri, array('location' => $desc_uri));
  }    
    
}
