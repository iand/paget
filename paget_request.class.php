<?php
class PAGET_Request {
  var $_config;
  var $resource_uri;
  var $resource_path;
  var $request_uri;
  var $representation_type;
  
  function __construct(&$config, $hostname, $path) {
    $this->_config = $config;
    $this->request_uri = 'http://' . $hostname . $path;

    $this->resource_path = $path;
    $this->representation_type = '';
    
    if ( preg_match('~^(.+)' . preg_quote ($this->_config['format_delimiter'])  . '(html|rdf|xml|turtle|json)$~', $this->resource_path, $m) ) {
      $this->resource_path = $m[1];
      $this->representation_type = $m[2];
    }

    $hostname = preg_replace('~\.local$~', '', $hostname);
    
    $this->resource_uri = 'http://' . $hostname . $this->resource_path;
  } 

  function select_mapping(&$resource_map) {
    foreach ( $resource_map as $mapping ) {
      if ( isset($mapping['path'])) {
        if (preg_match( '"' . $mapping['path'] . '"', $this->resource_path, $m)) {
          return $mapping;    
        }
      }
    }
    return NULL;
  }

}
