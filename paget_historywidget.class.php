<?php
class PAGET_HistoryWidget {
  var $desc;
  
  function __construct(&$desc) {
    $this->desc = $desc;  
  }

  function render($resource_info, $inline = FALSE, $brief = FALSE) {
    $resource_uri = $resource_info['value'];
    $index = $this->desc->get_index();
    $ret = '';
    $items = array();
    if (array_key_exists($resource_uri, $index)) {

      foreach ($index[$resource_uri] as $p => $v_list) {
        foreach ($v_list as $v_info) {
          if ( $p == 'http://purl.org/dc/terms/issued' && $v_info['type'] == 'literal') {
            $items[] = array('text' => 'first issued', 'date' => $v_info['value']);
          }
          else if ( $p == 'http://www.w3.org/2004/02/skos/core#changeNote' && ( $v_info['type'] == 'uri' || $v_info['type'] == 'bnode') ) {
            $text = $this->desc->get_first_literal($v_info['value'], 'http://www.w3.org/1999/02/22-rdf-syntax-ns#value', '');
            $date = $this->desc->get_first_literal($v_info['value'], 'http://purl.org/dc/elements/1.1/date', '');
            $creator = $this->desc->get_first_literal($v_info['value'], 'http://purl.org/dc/elements/1.1/creator', '');

            $items[] = array('text' => 'editorial change by ' . $creator . ': ' . $text, 'date' => $date);
          } 
          else if ( $p == 'http://www.w3.org/2004/02/skos/core#historyNote' ) {
            $text = $this->desc->get_first_literal($v_info['value'], 'http://www.w3.org/1999/02/22-rdf-syntax-ns#value', '');
            $date = $this->desc->get_first_literal($v_info['value'], 'http://purl.org/dc/elements/1.1/date', '');
            $creator = $this->desc->get_first_literal($v_info['value'], 'http://purl.org/dc/elements/1.1/creator', '');

            $items[] = array('text' => 'semantic change by ' . $creator . ': ' . $text, 'date' => $date);
          }       
        }     
      }
      
      if ( count($items) > 0 ) {
        $ret .= "<ul>\n";
        foreach ($items as $item) {
          $ret .= "<li>" . htmlspecialchars($item['date']) . ' - ' . htmlspecialchars($item['text']) . "</li>\n";
        }
        $ret .= "</ul>\n";
      }
    }
    return $ret;
  }
}
