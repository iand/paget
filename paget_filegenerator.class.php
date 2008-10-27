<?php
class PAGET_FileGenerator {
  var $_filename;
  var $_type;
  
  function __construct($filename, $type) {
    $this->_filename = $filename;
    $this->_type = $type;
  }
  
  function add_triples($resource_uri, &$desc) {
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
