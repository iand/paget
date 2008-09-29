<?php
class PAGET_ResourceDescription extends SimpleGraph {
  var $uri;
  var $request_factory;
  
  function __construct($config, $uri) {
    $this->uri = $uri;
  }
  

  
  function is_valid() {
    return !$this->is_empty();
  }
  
  function get_label() {
    $label = $this->get_first_literal($this->uri,RDFS_LABEL, '');
    if ( strlen($label) == 0) {
      $label = $this->get_first_literal($this->uri,DC_TITLE, '');
    }
    if ( strlen($label) == 0) {
      $label = $this->get_first_literal($this->uri,FOAF_NAME, '');
    }
    if ( strlen($label) == 0) {
      $label = $this->uri;
    }    
    return $label;
  }
  
  function add_resource_value($property, $value) {
    $this->add_resource_triple( $this->uri, $property, $value); 
  }
  
  function add_literal_value($property, $value) {
    $this->add_literal_triple( $this->uri, $property, $value);  
  }

}
