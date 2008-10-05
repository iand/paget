<?php
class PAGET_FileGenerator {
  var $_config = array();
  var $_filename;
  var $_type;
  
  function __construct(&$config, &$params) {
    $this->_config = $config;  
    $this->_filename = $params['file'];
    if (isset($params['type'])) {
      $this->_type = $params['type'];
    }
    else {
      $this->_type = 'rdfxml';
    }
  }
  
  function process(&$desc, $request) {
    $data = file_get_contents($this->_filename);
    if ( $this->_type === 'rdfxml' ) {
      $desc->add_rdfxml($data);
    }
    else if ( $this->_type === 'turtle' ) {
      $desc->add_turtle($data);
    }
    else if ( $this->_type === 'json' ) {
      $desc->add_json($data);
    }
  }

}
