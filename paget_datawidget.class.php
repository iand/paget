<?php
require_once "paget_widget.class.php";

class PAGET_DataWidget extends PAGET_Widget {
  var $image_properties =  array( 'http://xmlns.com/foaf/0.1/depiction', 'http://xmlns.com/foaf/0.1/img'); 
  var $property_order =  array('http://www.w3.org/2004/02/skos/core#prefLabel', RDFS_LABEL, 'http://purl.org/dc/terms/title', DC_TITLE, FOAF_NAME, 'http://www.w3.org/2004/02/skos/core#definition', RDFS_COMMENT, 'http://purl.org/dc/terms/description', DC_DESCRIPTION, 'http://purl.org/vocab/bio/0.1/olb', RDF_TYPE); 
  

  function render($resource_uri) {
    $index = $this->desc->get_index();
   
    if (array_key_exists($resource_uri, $index)) {
      $used_properties = array_keys($index[$resource_uri]);
      $properties = array_diff(array_diff(array_merge($this->property_order, array_diff($used_properties, $this->property_order)), $this->ignore_properties), $this->image_properties);
      
      $this->emit_image_properties($resource_uri, $this->image_properties);
      $this->emit_property_value_list($resource_uri, $properties);
    }
  }
}
