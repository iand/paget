<?php
require_once 'paget_widget.class.php';

class PAGET_RSSWidget extends PAGET_TableDataWidget {

  function render($resource_info, $inline = FALSE, $brief = FALSE) {
    if ($brief) return $this->render_brief($resource_info);  
    $ret  = '';
    
    $resource_uri = $resource_info['value'];
   
            
    $is_search = FALSE;     
    if ($this->desc->subject_has_property($resource_uri, 'http://a9.com/-/spec/opensearch/1.1/totalResults')) {
      // Assume it's a search feed
      $is_search = TRUE;
      
      $total_results = $this->desc->get_first_literal($resource_uri, 'http://a9.com/-/spec/opensearch/1.1/totalResults');
      $start_index = $this->desc->get_first_literal($resource_uri, 'http://a9.com/-/spec/opensearch/1.1/startIndex');
      $items_per_page = $this->desc->get_first_literal($resource_uri, 'http://a9.com/-/spec/opensearch/1.1/itemsPerPage');

      if (! is_numeric($items_per_page) || $items_per_page == 0) {
        $items_per_page = 30; 
      }
      if (! is_numeric($start_index)) {
        $start_index = 0; 
      }
      if (! is_numeric($total_results) || $total_results == 0) {
        $total_results = $start_index;  
      }

      $query = $this->template->request->data['query'];
    
      $ret .= $this->render_result_info($query, $total_results, $start_index, $items_per_page);
    }


    $values = $this->desc->get_subject_property_values($resource_uri, 'http://purl.org/rss/1.0/items');
    foreach ($values as $value_info) {
      $ret .= $this->template->render($value_info, FALSE, TRUE);
    }

    if ($is_search) {
      $search_uri = $this->template->request->full_path;
      $ret .= $this->render_pagination($search_uri, $query, $total_results, $start_index, $items_per_page);
    }    
    return $ret;
  }

  function render_result_info($query, $total_results, $start_index, $items_per_page) {
    $result_info  = '';
    if ($total_results == 0) {
      $result_info  = 'No resources matched <strong>' . htmlspecialchars($query) . '</strong>';    
    }
    else {
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

    return '<div id="resultinfo">' . $result_info . "</div>\n";
  }

  function render_pagination($search_uri, $query, $total_results, $start_index, $items_per_page) {
    $ret = '';
    
    $total_number_of_pages = ceil($total_results / $items_per_page);
    if ($total_number_of_pages > 1) {
      $ret = '<div class="paginator"><strong>Result pages: </strong><br />';
      $current_page = floor($start_index / $items_per_page) + 1;
       
      if ($current_page > 1) {
        $offset_raw = $start_index - $items_per_page;
        $offset_page = floor( $offset_raw / $items_per_page);
        $offset = $offset_page * $items_per_page;
        if ( $offset < 0 ) $offset = 0;
        $ret .= ' <a href="' . htmlspecialchars($search_uri) . '?query=' . htmlspecialchars($query) . '&offset=' . $offset . '">Prev</a>'; 
      } 
      if ($current_page > 6) {
        $page_links_start = $current_page - 5;
        $page_links_end = $current_page + 4;
      }
      else {
        $page_links_start = 1;
        $page_links_end = 10;
      }       
      if ($page_links_end > $total_number_of_pages) {
        $page_links_end = $total_number_of_pages;
      }
      
      for ($i = $page_links_start; $i <= $page_links_end;$i++ ) {
        if ($i == $current_page) {
          $ret .= ' ' . $i; 
        } 
        else {
          $offset_raw = $start_index - ($items_per_page * ($current_page - $i));
          $offset_page = floor( $offset_raw / $items_per_page);
          $offset = $offset_page * $items_per_page;
          if ( $offset < 0 ) $offset = 0;
          if ( $offset <= $total_results ) {
            $ret .= ' <a href="' . htmlspecialchars($search_uri) . '?query=' . htmlspecialchars($query) . '&offset=' . $offset . '">' . $i . '</a>'; 
          }
        }
      }

      if ($current_page < $total_number_of_pages) {
        $offset_raw = $start_index + $items_per_page;
        $offset_page = floor( $offset_raw / $items_per_page);
        $offset = $offset_page * $items_per_page;
        if ( $offset <= $total_results ) {
          $ret .= ' <a href="' . htmlspecialchars($search_uri) . '?query=' . htmlspecialchars($query) . '&offset=' . $offset . '">Next</a>'; 
        }
      } 
      $ret .= '</div>';
    }          
    return $ret;
  }

}
