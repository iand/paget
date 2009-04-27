<?php
require_once 'paget_widget.class.php';

class PAGET_RSSWidget extends PAGET_TableDataWidget {

  function render($resource_info, $inline = FALSE, $brief = FALSE) {
    if ($brief) return $this->render_brief($resource_info);  
    $ret  = '';
    
    $resource_uri = $resource_info['value'];
    $query = $this->desc->get_first_literal($resource_uri, 'http://purl.org/rss/1.0/title');
    
    if ($this->desc->subject_has_property($resource_uri, 'http://purl.org/rss/1.0/items')) {
      
      $result_info = '';
      
      if ($this->desc->subject_has_property($resource_uri, 'http://a9.com/-/spec/opensearch/1.1/totalResults')) {
        // Assume it's a search feed
        
        $total_results = $this->desc->get_first_literal($resource_uri, 'http://a9.com/-/spec/opensearch/1.1/totalResults');
        if ($total_results == 0) {
          $result_info  = 'No resources matched <strong>' . htmlspecialchars($query) . '</strong>';    
        }
        else {
          if ($this->desc->subject_has_property($resource_uri, 'http://a9.com/-/spec/opensearch/1.1/startIndex')
              && $this->desc->subject_has_property($resource_uri, 'http://a9.com/-/spec/opensearch/1.1/itemsPerPage')
            ) {
              
            $start_index = $this->desc->get_first_literal($resource_uri, 'http://a9.com/-/spec/opensearch/1.1/startIndex');
            $items_per_page = $this->desc->get_first_literal($resource_uri, 'http://a9.com/-/spec/opensearch/1.1/itemsPerPage');
            $end_index = $start_index + $items_per_page;
            if ($end_index > $total_results) {
              $end_index = $total_results;  
            }
            $result_info .= 'Results <strong>' . htmlspecialchars($start_index + 1) . ' - ' . htmlspecialchars($end_index) . '</strong> of ';
            
            if ($total_results - $start_index > 100) {
              $result_info .= 'about ';  
            }
            
            $result_info .='<strong>' . htmlspecialchars($total_results) . ' </strong> for <strong>' . htmlspecialchars($query) . '</strong>';
          }
          else {
            $result_info = '<strong>'. htmlspecialchars($total_results) . '</strong> results for <strong>' . htmlspecialchars($query) . '</strong>';
          }
        }
      
      }

      $ret .= '<div id="resultinfo">' . $result_info . "</div>\n";

      $values = $this->desc->get_subject_property_values($resource_uri, 'http://purl.org/rss/1.0/items');
      foreach ($values as $value_info) {
        $ret .= $this->template->render($value_info, FALSE, TRUE);
      }
    }
    
    return $ret;
  }



}
