<?php
require_once "paget_widget.class.php";

class PAGET_DataWidget extends PAGET_Widget {
  var $property_order =  array(RDFS_LABEL, DC_TITLE, FOAF_NAME, RDFS_COMMENT, DC_DESCRIPTION, 'http://purl.org/vocab/bio/0.1/olb', RDF_TYPE); 
  
  function render($resource_uri) {
    $index = $this->desc->get_index();
    $inverse_index = $this->desc->get_inverse_index();
    
    $used_properties = array_keys($index[$resource_uri]);
    $properties = array_merge($this->property_order, array_diff($used_properties, $this->property_order));
    
    $this->emit_property_value_list($resource_uri, $properties);


//    $this->emit_group(array(RDFS_LABEL, DC_TITLE, FOAF_NAME, RDFS_COMMENT, DC_DESCRIPTION, 'http://purl.org/vocab/bio/0.1/olb', RDF_TYPE), $resource_uri, $desc);
//    $this->emit_group('links', $resource_uri, $desc);
//    $this->emit_group('naming', $resource_uri, $desc);

  }
  


}
