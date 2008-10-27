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

//    $this->resource_path = $path;
    $this->representation_type = '';
    
    if ( preg_match('~^(.+)' . preg_quote ($this->_config['format_delimiter'])  . '(html|rdf|xml|turtle|json)$~', $this->resource_path, $m) ) {
//      $this->resource_path = $m[1];
      $this->representation_type = $m[2];
    }

//    $hostname = preg_replace('~\.local$~', '', $hostname);
   
//    $this->resource_uri = 'http://' . $hostname . $this->resource_path;
    $this->resource_uri = $this->extract_resource_uri($this->request_uri);
    //preg_replace('~vocab\.org~', 'purl.org/vocab', $this->resource_uri);
  } 

  function select_mapping(&$resource_map) {
    foreach ( $resource_map as $mapping ) {
      if ( isset($mapping['path'])) {
        if (preg_match( '"' . substr($mapping['path'], 1, strlen($mapping['path']) - 1) . '"', $this->resource_uri, $m)) {
          return $mapping;    
        }
      }
    }
    return NULL;
  }


  function extract_resource_uri($request_uri) {
//echo "Finding resource for " .  $request_uri;   
    
    $resource_uri = $request_uri;
echo "resource_uri is " . $resource_uri . "<br />\n";    
    $resource_uri = preg_replace('~' . preg_quote ($this->_config['format_delimiter'])  . '(html|rdf|xml|turtle|json)$~', '', $resource_uri);
echo "resource_uri is " . $resource_uri . "<br />\n";    
    $resource_uri = preg_replace('~\.local/~', '/', $resource_uri);
echo "resource_uri is " . $resource_uri . "<br />\n";    
    return $resource_uri;
  }

}


class PAGET_SimpleResourceMapper {
  function extract_resource_uri($request_uri) {
    $resource_uri = $request_uri;
    $resource_uri = preg_replace('~' . preg_quote ($this->_config['format_delimiter'])  . '(html|rdf|xml|turtle|json)$~', '', $resource_uri);
    $resource_uri = preg_replace('~\.local/~', '', $resource_uri);
    return $resource_uri;
  }
}
