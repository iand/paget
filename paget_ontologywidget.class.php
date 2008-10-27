<?php
require_once "paget_widget.class.php";
require_once MORIARTY_DIR . "httprequest.class.php";

class PAGET_OntologyWidget extends PAGET_Widget {
  var $desc;
  
  function __construct(&$desc) {
    $this->desc = $desc;  
  }
  
  
  function render($resource_uri) {
    $inline = array();
    
    $index = $this->desc->get_index();
    
    $descriptions = $this->desc->get_literal_triple_values($resource_uri, array(DC_DESCRIPTION, RDFS_COMMENT));
    if (count($descriptions) > 0) {
      foreach ($descriptions as $description) {
        echo '<p>' . htmlspecialchars($description) . '</p>';
      }
    }    
    
    $this->emit_property_value_list($resource_uri, array('http://purl.org/vocab/vann/preferredNamespaceUri',
                                                          'http://purl.org/vocab/vann/preferredNamespacePrefix',
                                                          'http://purl.org/dc/elements/1.1/contributor',
                                                        ));

    echo '<h2>Defined Terms</h2>';
    $inverse_index = $this->desc->get_inverse_index();
    $def_uri = '';
    if (array_key_exists($resource_uri, $inverse_index) && array_key_exists(RDFS_ISDEFINEDBY, $inverse_index[$resource_uri])) {
      $def_uri =  $resource_uri;
    }
    else if (array_key_exists($resource_uri . '/', $inverse_index) && array_key_exists(RDFS_ISDEFINEDBY, $inverse_index[$resource_uri . '/'])) {
      $def_uri =  $resource_uri . '/';
    }
    
    if (strlen($def_uri) > 0) {
      $tw = new PAGET_TermWidget($this->desc);
      
      foreach ($inverse_index[$def_uri][RDFS_ISDEFINEDBY] as $v_info) {
        echo '<h3>' . htmlspecialchars($tw->get_title($v_info['value'])) . '</h3>';
        $tw->render_short($v_info['value']);
      }
    }
    

  
        
    foreach ($index[$resource_uri] as $p => $v_list) {
      foreach ($v_list as $v_info) {
        if ( $p == 'http://purl.org/vocab/vann/example' && $v_info['type'] == 'uri') {
          $title = $this->desc->get_first_literal($v_info['value'], array(RDFS_LABEL, DC_TITLE), 'Example');
          
          $req = new HttpRequest('GET', $v_info['value']);
          $response = $req->execute();
          if ($response->is_success()) {
            echo '<h3>' . htmlspecialchars($title) . '</h3>';  
            echo $response->body;
          }
          else {
            echo '<h3><a href="' . htmlspecialchars($v_info['value']) . '">' . htmlspecialchars($title) . '</a></h3>';
          }
        }
      }     
    }

  }
}
