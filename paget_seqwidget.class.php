<?php
require_once 'paget_widget.class.php';

class PAGET_SeqWidget extends PAGET_Widget {
  var $desc;
  var $template;
  
  function __construct(&$desc, $template = NULL) {
    $this->desc = $desc;  
    $this->template = $template;  
  }

  function render($resource_info, $inline = FALSE) {
    $data = array();
    $resource_uri = $resource_info['value'];
    $props = $this->desc->get_subject_properties($resource_uri, TRUE);
    $list_items = array();
    foreach ($props as $prop) {
      if ( preg_match("~^http://www.w3.org/1999/02/22-rdf-syntax-ns#_(\d+)$~", $prop, $m)) {
        $list_items[$m[1]] = array('property' => $prop, 'values' => $this->desc->get_subject_property_values($resource_uri, $prop));
      }
    }
    
    ksort($list_items, SORT_NUMERIC);
    if ($inline) {

    }
    else {
      $ret .= '<ol>';
      foreach ($list_items as $number => $values) {
        foreach ($values['values'] as $value_info) {
          $ret .= '<li>';
          $ret .= $this->template->render($value_info, FALSE, TRUE);
          $ret .= '</li>' . "\n";
        }
      }
      $ret .= '</ol>';
    }
    
    return $ret;
  }  

}
