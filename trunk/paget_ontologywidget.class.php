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
    
    $key_properties = array('http://purl.org/vocab/vann/preferredNamespaceUri',
                                                          'http://purl.org/vocab/vann/preferredNamespacePrefix',
                                                          'http://purl.org/dc/elements/1.1/contributor',
                                                          'http://purl.org/dc/elements/1.1/rights',
                                                        );
    
    $this->emit_property_value_list($resource_uri,$key_properties);

    $inverse_index = $this->desc->get_inverse_index();
    $def_uri = '';
    if (array_key_exists($resource_uri, $inverse_index) && array_key_exists(RDFS_ISDEFINEDBY, $inverse_index[$resource_uri])) {
      $def_uri =  $resource_uri;
    }
    else if (array_key_exists($resource_uri . '/', $inverse_index) && array_key_exists(RDFS_ISDEFINEDBY, $inverse_index[$resource_uri . '/'])) {
      $def_uri =  $resource_uri . '/';
    }
    
    if (strlen($def_uri) > 0) {
      
      $terms = $inverse_index[$def_uri][RDFS_ISDEFINEDBY];
      if  (count($terms) > 0) {
        $tw = new PAGET_TermWidget($this->desc);
        $rows = array();
        foreach ($terms as $v_info) {
          if ( $v_info['type'] == 'uri' ) {
            $term_uri = $v_info['value'];
            $title = $tw->get_title($term_uri);
            $row = '<tr><td valign="top"><a href="' . htmlspecialchars($term_uri) . '">' . htmlspecialchars($title) . '</a></td>';
            $row .= '<td valign="top">' . htmlspecialchars($tw->get_description($term_uri)) . '</td></tr>';
    
            $rows[$title] = $row;
          }
        }
        if (count($rows)  > 0) { 
          ksort( $rows );
          echo '<h2>Properties and Classes</h2>';
          echo '<table>';
          foreach ($rows as $key => $row) {
            echo $row . "\n";   
          }
          echo '</table>';
        }
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


    echo '<h2>History</h2>';
    $history_widget = new PAGET_HistoryWidget($this->desc);
    $history_widget->render($resource_uri);
    
    
    echo '<h2>Other Information</h2>';
    $data_widget = new PAGET_DataWidget($this->desc);
    $data_widget->ignore_properties(array(DC_TITLE, RDFS_LABEL, DC_DESCRIPTION, RDFS_COMMENT, 'http://purl.org/vocab/vann/example'));
    $data_widget->ignore_properties($key_properties);
    $data_widget->ignore_properties(array('http://www.w3.org/2004/02/skos/core#changeNote', 'http://www.w3.org/2004/02/skos/core#historyNote', 'http://purl.org/dc/terms/issued'));
    $data_widget->render($resource_uri);

  }
}
