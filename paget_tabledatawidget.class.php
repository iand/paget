<?php
require_once "paget_widget.class.php";

class PAGET_TableDataWidget extends PAGET_Widget {
  var $image_properties =  array( 'http://xmlns.com/foaf/0.1/depiction', 'http://xmlns.com/foaf/0.1/img'); 
  var $property_order =  array('http://www.w3.org/2004/02/skos/core#prefLabel', RDFS_LABEL, 'http://purl.org/dc/terms/title', DC_TITLE, FOAF_NAME, 'http://www.w3.org/2004/02/skos/core#definition', 'http://open.vocab.org/terms/subtitle', RDFS_COMMENT, 'http://purl.org/dc/terms/description', DC_DESCRIPTION, 'http://purl.org/vocab/bio/0.1/olb', RDF_TYPE, 'http://xmlns.com/foaf/0.1/depiction', 'http://xmlns.com/foaf/0.1/img'); 
  var $ignore_properties = array();
  
  function ignore_properties($properties) {
    $this->ignore_properties = array_merge($this->ignore_properties, $properties);
  }
  
  function render($resource_uri) {
    $index = $this->desc->get_index();
    //$inverse_index = $this->desc->get_inverse_index();
    
    if (array_key_exists($resource_uri, $index)) {
      $used_properties = array_keys($index[$resource_uri]);
      $properties = array_diff(array_merge($this->property_order, array_diff($used_properties, $this->property_order)), $this->ignore_properties);
      
      $this->emit_property_value_list($resource_uri, $properties);
    }

  }
  

  function emit_property_value_list($resource_uri, $properties) {
    $data = array();
    foreach ($properties as $property) {
      $property_values = $this->desc->get_subject_property_values($resource_uri, $property);
      if ( count($property_values) > 0) {
    
        if ( count($property_values) == 1) {
          $label = ucfirst($this->desc->get_first_literal($property, RDFS_LABEL));
        }
        else {
          $label = ucfirst($this->desc->get_first_literal($property, 'http://purl.org/net/vocab/2004/03/label#plural'));
        }         
        
        
        $formatted_label = $this->format_property_label($property, $label);
        $formatted_value = $this->format_property_values($property, $property_values);

        $data[] = array('label' => $formatted_label, 'value' => $formatted_value );
      }
    }
    /*
    if (array_key_exists($resource_uri, $this->inverse_index)) {
      foreach ($this->inverse_index[$resource_uri] as $property => $property_values) {
        $label = ucfirst($this->desc->get_first_literal($property, 'http://purl.org/net/vocab/2004/03/label#inverseSingular'));
        $formatted_label = $this->format_property_label($property, $label);
        $formatted_value = $this->format_property_values($property, $property_values);

        $data[] = array('label' => $formatted_label, 'value' => $formatted_value );
      }
    
    } 
    */   
    $this->emit_table($data);   
  }    


  function format_property_values($property, &$property_values) {
    $formatted_value = '';
    $values = array();
    
    for ($i = 0; $i < count($property_values); $i++) {
      if ($property_values[$i]['type'] == 'uri') {
        if ( in_array($property, $this->image_properties)) {
          $values[] = '<a href="' . htmlspecialchars($property_values[$i]['value'] ) . '"><img src="' . htmlspecialchars($property_values[$i]['value'] ) . '" /></a>';
        }
        else  {
          $values[] = $this->link_uri($property_values[$i]['value']);
        }
      }
      else {
        $text = htmlspecialchars($property_values[$i]['value']);
        if (isset($property_values[$i]['lang'])) {
          $text .= ' <span class="lang">[' . htmlspecialchars($property_values[$i]['lang']) . ']</span>';
        }
        $values[] = $text;
      }
    }   
    sort($values);
    return join('<br />', $values);
  }

}
