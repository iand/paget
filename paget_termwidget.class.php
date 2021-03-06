<?php
require_once 'paget_widget.class.php';

class PAGET_TermWidget extends PAGET_Widget {
  var $desc;
  
  function __construct(&$desc) {
    $this->desc = $desc;  
  }

  function render($resource_uri) {
    $index = $this->desc->get_index();
    $inverse_index = $this->desc->get_inverse_index();
    $is_property = $this->desc->has_resource_triple( $resource_uri, RDF_TYPE, RDF_PROPERTY );

    echo '<div class="terminfo">' . htmlspecialchars($this->get_description($resource_uri)) . '</div>';
    
    $data = array();
    $data[] = array('label' => 'Full URI', 'value' => '<a href="' . htmlspecialchars($this->remote_to_local($resource_uri)) . '" class="uri">' . htmlspecialchars($this->remote_to_local($resource_uri)) . '</a>');
    $this->emit_key_value($data);  


?>
<?php


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
      echo '<h2>Characteristics</h2>';      
      echo '<p>This property is ';
      for ($i = 0; $i < count($characteristics); $i++) {
        if ( $i > 0 ) {
          if ($i == count($characteristics) - 1) { echo ' and '; }
          else { echo ', '; }
        }
        echo $characteristics[$i];
      }
      echo '</p>';
      
    }
    
    if ( $this->desc->subject_has_property($resource_uri, RDFS_DOMAIN) || $this->desc->subject_has_property($resource_uri, RDFS_RANGE ) ) {
      echo '<h2>Property Information</h2>';
      $this->list_relations_prose($index, $resource_uri, RDFS_DOMAIN, 'Having this property implies being ');
      $this->list_relations_prose($index, $resource_uri, RDFS_RANGE, 'Every value of this property is ');
    }
    if (      $this->desc->subject_has_property($resource_uri, RDFS_SUBPROPERTYOF) 
          ||  $this->desc->subject_has_property($resource_uri, OWL_EQUIVALENTPROPERTY ) 
          ||  $this->desc->subject_has_property($resource_uri, OWL_INVERSEOF ) 
        
        ) {
      echo '<h2>Relation to Other Properties</h2>';
      $this->list_relations($index, $resource_uri, RDFS_SUBPROPERTYOF, 'Sub-property of');
      $this->list_relations($index, $resource_uri, OWL_EQUIVALENTPROPERTY, 'Equivalent to');
      $this->list_relations($index, $resource_uri, OWL_INVERSEOF, 'Inverse of');
    }
  }
  else {


    if ( $this->desc->subject_has_property($resource_uri, RDFS_SUBCLASSOF) || 
          $this->desc->subject_has_property($resource_uri, OWL_DISJOINTWITH)
        ) {
      echo '<h2>Class Membership</h2>';
      $this->list_relations_prose($index, $resource_uri, RDFS_SUBCLASSOF, 'Being a member of this class implies also being a member of ', '', false);
      $this->list_relations_prose($index, $resource_uri, OWL_DISJOINTWITH, 'No member of this class can also be a member of ', '', false, 'or');
      $this->list_relations_prose($inverse_index, $resource_uri, RDFS_DOMAIN, 'Having', 'implies being a member of this class.', true, 'or');
      $this->list_relations_prose($inverse_index, $resource_uri, RDFS_RANGE, 'Things are a member of this class if they are the value of ', '', true, 'or');

      
    }

    if ( $this->desc->subject_has_property($resource_uri, OWL_EQUIVALENTCLASS) ) {
      echo '<h2>Relation to Other Classes</h2>';
      $this->list_relations($index, $resource_uri, OWL_EQUIVALENTCLASS, 'Equivalent to');
    }
  }
  
    if ( $this->desc->subject_has_property($resource_uri, 'http://www.w3.org/2004/02/skos/core#changeNote') || $this->desc->subject_has_property($resource_uri, 'http://www.w3.org/2004/02/skos/core#historyNote' ) || $this->desc->subject_has_property($resource_uri, 'http://purl.org/dc/terms/issued' ) ) {
      echo '<h2>History</h2>';
      $history_widget = new PAGET_HistoryWidget($this->desc);
      $history_widget->render($resource_uri);
    }    
    
    echo '<h2>Other Information</h2>';
    $data_widget = new PAGET_DataWidget($this->desc);
    $data_widget->ignore_properties(array(DC_TITLE, RDFS_LABEL, DC_DESCRIPTION, RDFS_COMMENT, 'http://purl.org/vocab/vann/example', 'http://www.w3.org/2003/06/sw-vocab-status/ns#term_status', 'http://www.w3.org/2004/02/skos/core#definition'));
    $data_widget->ignore_properties(array(OWL_EQUIVALENTCLASS, RDFS_RANGE, RDFS_DOMAIN, OWL_DISJOINTWITH, RDFS_SUBCLASSOF, RDFS_SUBPROPERTYOF, OWL_EQUIVALENTPROPERTY, OWL_INVERSEOF, OWL_SYMMETRICPROPERTY, OWL_FUNCTIONALPROPERTY, OWL_INVERSEFUNCTIONALPROPERTY, OWL_TRANSITIVEPROPERTY ));
    $data_widget->ignore_properties(array('http://www.w3.org/2004/02/skos/core#changeNote', 'http://www.w3.org/2004/02/skos/core#historyNote', 'http://purl.org/dc/terms/issued'));
    $data_widget->render($resource_uri);    
  }  
  
  
  
  function get_description($resource_uri) {
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
        $status = 'is deemed to be semantically stable. Its meaning should not change in the foreseable future.'; 
      }
      else if ( $status_code == 'testing') {
        $status = 'is undergoing testing to determine if it is semantically stable. Its meaning may change in the foreseable future.';  
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

    $comments = $this->desc->get_literal_triple_values($resource_uri, RDFS_COMMENT);  
    foreach ($comments as $comment) {
      $info .= ' ' . $comment;        
    }

    if (strlen($status) > 0) {
      if (strlen($info) > 0 ) {
        $info .= 'It ' . $status;
      }
      else  {
        $info = 'This term ' . $status;
      }
    }    
    
    return $info;
    
  }


  function list_relations_prose(&$index, $uri, $property, $prefix, $suffix='', $use_definite_article = true, $conjunction = 'and') {
    if ( array_key_exists($uri, $index)) {
      if ( array_key_exists($property, $index[$uri])) {
        echo '<p>' . htmlspecialchars($prefix) . ' ';
        for ($i = 0 ; $i < count($index[$uri][$property]); $i++) {
          if ($i > 0) {
            if ($i < count($index[$uri][$property]) - 1) { echo ', '; }      
            else if ($i == count($index[$uri][$property]) - 1) { echo ' ' . $conjunction . ' '; }      
          }
          $text = $index[$uri][$property][$i]['value'];


          
          echo $this->link_uri($text, '', $use_definite_article);
        }
        echo ' ' . htmlspecialchars($suffix);
        echo '</p>' . "\n"; 
      }
    }
  }


  function list_relations(&$index, $uri, $property, $label) {
    if ( array_key_exists($uri, $index)) {
      if ( array_key_exists($property, $index[$uri])) {
        echo '<p>' . htmlspecialchars($label) . ': ';
        for ($i = 0 ; $i < count($index[$uri][$property]); $i++) {
          if ($i > 0) { echo ', '; }      
          echo $this->link_uri($index[$uri][$property][$i]['value']);
        }
        echo '</p>' . "\n"; 
      }
    }
  }
  
  function remote_to_local($uri) {
    if (preg_match('~http://([^/]+)/~i', $uri, $m)) {
      if ( $_SERVER["HTTP_HOST"] == $m[1] . '.local' ) {
        return str_replace($m[1], $_SERVER["HTTP_HOST"], $uri);
      }
      else {
        return $uri;
      }
    }
  }  
  



}
