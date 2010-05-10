<?php
require_once 'paget_widget.class.php';

class PAGET_HistoryWidget extends PAGET_Widget {

  function render($resource_info, $inline = FALSE, $brief = FALSE) {
    $resource_uri = $resource_info['value'];
    $index = $this->desc->get_index();
    $ret = '';
    $items = array();
    if (array_key_exists($resource_uri, $index)) {

      foreach ($index[$resource_uri] as $p => $v_list) {
        foreach ($v_list as $v_info) {
          if ( $p == 'http://purl.org/dc/terms/issued' && $v_info['type'] == 'literal') {
            $items[] = sprintf('%s - first issued', $v_info['value']);
          }
          else if ( $p == 'http://www.w3.org/2004/02/skos/core#changeNote' && ( $v_info['type'] == 'uri' || $v_info['type'] == 'bnode') ) {
            $text = htmlspecialchars($this->desc->get_label($v_info['value']));
//            $date = $this->desc->get_first_literal($v_info['value'], array('http://purl.org/dc/terms/date', 'http://purl.org/dc/elements/1.1/date'), '');
//            $creator = $this->desc->get_first_literal($v_info['value'], array('http://purl.org/dc/terms/creator', 'http://purl.org/dc/elements/1.1/creator'), '');

            $date = $this->format_property_values('http://purl.org/dc/terms/date', $this->desc->get_subject_property_values($v_info['value'], array('http://purl.org/dc/terms/date', 'http://purl.org/dc/elements/1.1/date')) );
            $creator = $this->format_property_values('http://purl.org/dc/terms/creator', $this->desc->get_subject_property_values($v_info['value'], array('http://purl.org/dc/terms/creator', 'http://purl.org/dc/elements/1.1/creator')) );


            $items[] = sprintf('%s - editorial change by %s: %s', $date, $creator, $text);
          } 
          else if ( $p == 'http://www.w3.org/2004/02/skos/core#historyNote' ) {
            $text = htmlspecialchars($this->desc->get_label($v_info['value']));
//            $text = $this->desc->get_first_literal($v_info['value'], 'http://www.w3.org/1999/02/22-rdf-syntax-ns#value', '');
//            $date = $this->desc->get_first_literal($v_info['value'], array('http://purl.org/dc/terms/date', 'http://purl.org/dc/elements/1.1/date'), '');
//            $creator = $this->desc->get_first_literal($v_info['value'], array('http://purl.org/dc/terms/creator', 'http://purl.org/dc/elements/1.1/creator'), '');
            $date = $this->format_property_values('http://purl.org/dc/terms/date', $this->desc->get_subject_property_values($v_info['value'], array('http://purl.org/dc/terms/date', 'http://purl.org/dc/elements/1.1/date')) );
            $creator = $this->format_property_values('http://purl.org/dc/terms/creator', $this->desc->get_subject_property_values($v_info['value'], array('http://purl.org/dc/terms/creator', 'http://purl.org/dc/elements/1.1/creator')) );

            $items[] = sprintf('%s - semantic change by %s: %s', $date, $creator, $text);
          }       
        }     
      }
      
      sort($items);
      
      if ( count($items) > 0 ) {
        $ret .= "<ul>\n";
        foreach ($items as $item) {
          $ret .= "<li>" . $item . "</li>\n";
        }
        $ret .= "</ul>\n";
      }
    }
    return $ret;
  }
}
