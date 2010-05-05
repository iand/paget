<?php
require_once 'paget_widget.class.php';

class PAGET_TermWidget extends PAGET_Widget {

  function render($resource_info, $inline = FALSE, $brief = FALSE, $level = 1) {
    if ($brief) return $this->render_brief($resource_info, $inline);
    $resource_uri = $resource_info['value'];
   
    if (!$inline) {
      $ret .= '<h' . $level  . '>' .htmlspecialchars( $this->get_title($resource_uri)) . '</h' . $level  . '>';
    }


    $index = $this->desc->get_index();
    $inverse_index = $this->desc->get_inverse_index();
    $is_property = $this->desc->has_resource_triple( $resource_uri, RDF_TYPE, RDF_PROPERTY );

    $ret .= '<div class="termuri"><strong>URI:</strong> ' . $this->link_uri($resource_uri, $resource_uri) . '</div>';
    $ret .= '<div class="terminfo">' . htmlspecialchars($this->get_description($resource_uri)) . ' ';
    
    $data = array();


    if ($is_property) {
      $characteristics = array();
      
      if ( $this->desc->has_resource_triple( $resource_uri, RDF_TYPE, OWL_SYMMETRICPROPERTY ) ) {
        $characteristics[] = 'symmetrical';
      }
      if ( $this->desc->has_resource_triple( $resource_uri, RDF_TYPE, OWL_TRANSITIVEPROPERTY ) ) {
        $characteristics[] = 'transitive';
      }
      if ( $this->desc->has_resource_triple( $resource_uri, RDF_TYPE, OWL_FUNCTIONALPROPERTY ) ) {
        $characteristics[] = 'functional';
      }
      if ( $this->desc->has_resource_triple( $resource_uri, RDF_TYPE, OWL_INVERSEFUNCTIONALPROPERTY ) ) {
        $characteristics[] = 'inverse functional';
      }
    
        
      if ( count($characteristics) > 0 ) {
        $ret .=  'This property is ';
        for ($i = 0; $i < count($characteristics); $i++) {
          if ( $i > 0 ) {
            if ($i == count($characteristics) - 1) { $ret .= ' and '; }
            else { $ret .=  ', '; }
          }
          $ret .=  $characteristics[$i];
        }
        $ret .= '. '; 
      }
      
      $ret .= $this->list_relations_prose($index, $resource_uri, RDFS_DOMAIN, 'Having this property implies being ','. ');
      $ret .= $this->list_relations_prose($index, $resource_uri, RDFS_RANGE, 'Every value of this property is ','. ');

      if ( $this->desc->subject_has_property($resource_uri, OWL_INVERSEOF ) ) {
        if ( $this->desc->subject_has_property($resource_uri, RDFS_SUBPROPERTYOF ) ) {
          $ret .= $this->list_relations_prose($index, $resource_uri, RDFS_SUBPROPERTYOF, 'It is a sub-property of ', ' and ', FALSE);
        }
        else {
          $ret .= 'It is ';  
        }
        $ret .= $this->list_relations_prose($index, $resource_uri, OWL_INVERSEOF, 'the inverse of ', '', FALSE);
      }
      else {
        $ret .= $this->list_relations_prose($index, $resource_uri, RDFS_SUBPROPERTYOF, 'It is a sub-property of ', '. ', FALSE);
      }
      $ret .= $this->list_relations_prose($index, $resource_uri, OWL_EQUIVALENTPROPERTY, 'It is equivalent to ', '', FALSE);
      
      
    }
    else {

      $ret .= $this->list_relations_prose($index, $resource_uri, RDFS_SUBCLASSOF, 'Being a member of this class implies also being a member of ', '. ', false);
      $ret .= $this->list_relations_prose($index, $resource_uri, OWL_DISJOINTWITH, 'No member of this class can also be a member of ', '. ', false, 'or');
      $ret .= $this->list_relations_prose($inverse_index, $resource_uri, RDFS_DOMAIN, 'Having', ' implies being a member of this class. ', true, 'or');
      $ret .= $this->list_relations_prose($inverse_index, $resource_uri, RDFS_RANGE, 'Things are a member of this class if they are the value of ', '. ', true, 'or');
      $ret .= $this->list_relations_prose($index, $resource_uri, OWL_EQUIVALENTCLASS, 'It is equivalent to ', '. ', FALSE);
    }
  
    $ret .= '</div>';
  
    if ( $this->desc->subject_has_property($resource_uri, 'http://purl.org/vocab/vann/usageNote') ) {
      $ret .= '<h' . ($level + 1) . '>Usage</h' . ($level + 1) . '>';
      $literal_widget = new PAGET_LiteralWidget($this->desc, $this->template, $this->urispace);
      foreach ($this->desc->get_subject_property_values($resource_uri, 'http://purl.org/vocab/vann/usageNote') as $value) {
        $ret .= sprintf('<div class="usagenote">%s</div>', $literal_widget->render($value, FALSE, FALSE));
      }
    }

    if ( $this->desc->subject_has_property($resource_uri, 'http://purl.org/vocab/vann/example') ) {
      $ret .= '<h' . ($level + 1) . '>Examples</h' . ($level + 1) . '>';
      foreach ($this->desc->get_subject_property_values($resource_uri, 'http://purl.org/vocab/vann/example') as $v_info) {
        $title = $this->desc->get_first_literal($v_info['value'], array(RDFS_LABEL, DC_TITLE), 'Example', 'en');
        $comment = $this->desc->get_first_literal($v_info['value'], array(RDFS_COMMENT), '', 'en');
        if ($comment) {
          $ret .=  '<h' . ($level + 2) . '>' . htmlspecialchars($title) . '</h' . ($level + 2) . '>';
          $ret .=  $comment;
        }
      }

    }
  
    if ( $this->desc->subject_has_property($resource_uri, 'http://www.w3.org/2004/02/skos/core#changeNote') || $this->desc->subject_has_property($resource_uri, 'http://www.w3.org/2004/02/skos/core#historyNote' ) || $this->desc->subject_has_property($resource_uri, 'http://purl.org/dc/terms/issued' ) ) {
      $ret .= '<h' . ($level + 1) . '>History</h' . ($level + 1) . '>';
      $history_widget = new PAGET_HistoryWidget($this->desc, $this->template, $this->urispace);
      $ret .= $history_widget->render($resource_info, FALSE, FALSE);
    }    
    
    $data_widget = new PAGET_TableDataWidget($this->desc, $this->template, $this->urispace);
    $data_widget->ignore_properties($this->ignore_properties);
    $data_widget->ignore_properties(array(RDF_TYPE, DC_TITLE, RDFS_LABEL, DC_DESCRIPTION, RDFS_COMMENT, 'http://purl.org/vocab/vann/example', 'http://www.w3.org/2003/06/sw-vocab-status/ns#term_status', 'http://www.w3.org/2004/02/skos/core#definition'));
    $data_widget->ignore_properties(array(OWL_EQUIVALENTCLASS, RDFS_RANGE, RDFS_DOMAIN, OWL_DISJOINTWITH, RDFS_SUBCLASSOF, RDFS_SUBPROPERTYOF, OWL_EQUIVALENTPROPERTY, OWL_INVERSEOF, OWL_SYMMETRICPROPERTY, OWL_FUNCTIONALPROPERTY, OWL_INVERSEFUNCTIONALPROPERTY, OWL_TRANSITIVEPROPERTY ));
    $data_widget->ignore_properties(array('http://www.w3.org/2004/02/skos/core#changeNote', 'http://www.w3.org/2004/02/skos/core#historyNote', 'http://purl.org/dc/terms/issued'));
    $data_widget->ignore_properties(array('http://purl.org/vocab/vann/usageNote', 'http://purl.org/net/vocab/2004/03/label#plural'));
    $other .= $data_widget->render($resource_info, FALSE, FALSE);    
    if (strlen(trim($other)) > 0) {
      $ret .=  '<h' . ($level + 1) . '>Other Information</h' . ($level + 1) . '>' . $other;
    }
    
    return $ret;
  }  
  
  
  
  function get_description($resource_uri, $brief = FALSE) {
    $definition = '';
    $status = '';
    $intro = '';
    $info = '';
    
    if ($this->desc->has_resource_triple( $resource_uri, RDF_TYPE, RDF_PROPERTY )) {
      $intro = 'A property representing ';
    }
    else if ($this->desc->has_resource_triple( $resource_uri, RDF_TYPE, RDFS_CLASS )) {
      $intro = 'A class whose members are ';
    }

    
    if ($this->desc->subject_has_property($resource_uri, 'http://www.w3.org/2003/06/sw-vocab-status/ns#term_status')) {
      $status_code = $this->desc->get_first_literal($resource_uri, 'http://www.w3.org/2003/06/sw-vocab-status/ns#term_status', '');
      if ( $status_code == 'unstable') {
        $status = 'is deemed to be semantically unstable and is subject to its meaning being changed.'; 
      }
      else if ( $status_code == 'stable') {
        $status = 'is deemed to be semantically stable and its meaning should not change in the foreseable future.'; 
      }
      else if ( $status_code == 'testing') {
        $status = 'is undergoing testing to determine if it is semantically stable and its meaning may change in the foreseable future.';  
      }
    }
    
    if ($this->desc->subject_has_property($resource_uri, 'http://www.w3.org/2004/02/skos/core#definition')) {
      if (strlen($info) == 0 && strlen(intro) > 0) {
        $info = $intro . lcfirst($this->desc->get_first_literal($resource_uri, 'http://www.w3.org/2004/02/skos/core#definition', ''));
      }
      else {
        $info .= $this->desc->get_first_literal($resource_uri, 'http://www.w3.org/2004/02/skos/core#definition', '');       
      }
    }
    $info .= $this->add_period_if_needed($info);

    if ($brief == FALSE || strlen($info) == 0) {
      $comments = $this->desc->get_literal_triple_values($resource_uri, RDFS_COMMENT);  
      foreach ($comments as $comment) {
        $info .= ' ' . $comment;        
        $info .= $this->add_period_if_needed($info);
      }

      if (strlen($status) > 0) {
        $info .= $this->add_period_if_needed($info);
        $info .= ' This term ' . $status;
      }    
    }    
    return $info;
    
  }

  function add_period_if_needed($text) {
    if (strlen($text) ==0 || preg_match('~\.\s*$~', $text) ) return '';
    return '. ';
  }


  function list_relations_prose(&$index, $uri, $property, $prefix, $suffix='', $use_definite_article = true, $conjunction = 'and') {
    $ret = '';
    if ( array_key_exists($uri, $index)) {
      if ( array_key_exists($property, $index[$uri])) {
        $ret .=  htmlspecialchars($prefix) . ' ';
        $values = array();
        for ($i = 0 ; $i < count($index[$uri][$property]); $i++) {
          if ($index[$uri][$property][$i]['value'] != $uri) {
            $values[] = $index[$uri][$property][$i];
          }
        }
        
        for ($i = 0 ; $i < count($values); $i++) {
          if ($i > 0) {
            if ($i < count($values) - 1) { $ret .=  ', '; }      
            else if ($i == count($values) - 1) { $ret .=  ' ' . $conjunction . ' '; }      
          }
          $text = $values[$i]['value'];
          $ret .=  $this->link_uri($text, '', $use_definite_article);
        }
        $ret .=  htmlspecialchars($suffix);
      }
    }
    
    return $ret;
  }


  function list_relations(&$index, $uri, $property, $label) {
    $ret = '';
    if ( array_key_exists($uri, $index)) {
      if ( array_key_exists($property, $index[$uri])) {
        $ret .=  htmlspecialchars($label) . ': ';
        for ($i = 0 ; $i < count($index[$uri][$property]); $i++) {
          if ($i > 0) { $ret .= ', '; }      
          $ret .=  $this->link_uri($index[$uri][$property][$i]['value']);
        }
      }
    }
    $ret .=  '.'; 
    return $ret;
  }
}
