<?php

// An augmentor that does simple inferencing for domains/ranges, subclasses, subproperties, symmetric and transitive properties
// This is not and never will be a full reasoner
class PAGET_SimpleInferencer {
                
                                               
  function __construct() {

  }
  
  function process(&$desc) {
    $this->_add_axioms($desc);
    
    $index = $desc->get_index();
    $property_index = array();
    foreach ($index as $s => $p_list) {
      foreach ($p_list as $p => $val_list) {
        foreach ($val_list as $val_info) {    
          if ($val_info['type'] == 'uri' || $val_info['type'] == 'bnode' ) {
            if (! array_key_exists($p, $property_index)) {
              $property_index[$p] = array();
            }
            $property_index[$p][] = array('s'=>$s, 'o'=>$val_info['value']);
          }     
        }
      }
    }

    $this->_process_subproperties($desc, $property_index);
    $this->_process_symmetric_properties($desc, $property_index);
    $this->_process_transitive_properties($desc, $property_index);
    $this->_process_type_inference($desc, $property_index);
    
  }

  function _add_axioms(&$desc) {
    //$desc->add_resource_triple(RDF_TYPE, RDFS_DOMAIN, RDFS_RESOURCE);
    $desc->add_resource_triple(RDFS_DOMAIN, RDFS_DOMAIN, RDF_PROPERTY);
    $desc->add_resource_triple(RDFS_RANGE, RDFS_DOMAIN, RDF_PROPERTY);
    $desc->add_resource_triple(RDFS_SUBPROPERTYOF, RDFS_DOMAIN, RDF_PROPERTY);
    $desc->add_resource_triple(RDFS_SUBCLASSOF, RDFS_DOMAIN, RDFS_CLASS);
    $desc->add_resource_triple(RDF_SUBJECT, RDFS_DOMAIN, RDF_STATEMENT);
    $desc->add_resource_triple(RDF_PREDICATE, RDFS_DOMAIN, RDF_STATEMENT);
    $desc->add_resource_triple(RDF_OBJECT, RDFS_DOMAIN, RDF_STATEMENT);
    //$desc->add_resource_triple(RDFS_MEMBER, RDFS_DOMAIN, RDFS_RESOURCE);
    $desc->add_resource_triple(RDF_FIRST, RDFS_DOMAIN, RDF_LIST);
    $desc->add_resource_triple(RDF_REST, RDFS_DOMAIN, RDF_LIST);
    //$desc->add_resource_triple(RDFS_SEEALSO, RDFS_DOMAIN, RDFS_RESOURCE);
    //$desc->add_resource_triple(RDFS_ISDEFINEDBY, RDFS_DOMAIN, RDFS_RESOURCE);
    //$desc->add_resource_triple(RDFS_COMMENT, RDFS_DOMAIN, RDFS_RESOURCE);
    //$desc->add_resource_triple(RDFS_LABEL, RDFS_DOMAIN, RDFS_RESOURCE);
    //$desc->add_resource_triple(RDF_VALUE, RDFS_DOMAIN, RDFS_RESOURCE);

    $desc->add_resource_triple(RDF_TYPE, RDFS_RANGE, RDFS_CLASS);
    $desc->add_resource_triple(RDFS_DOMAIN, RDFS_RANGE, RDFS_CLASS);
    $desc->add_resource_triple(RDFS_RANGE, RDFS_RANGE, RDFS_CLASS);
    $desc->add_resource_triple(RDFS_SUBPROPERTYOF, RDFS_RANGE, RDF_PROPERTY);
    $desc->add_resource_triple(RDFS_SUBCLASSOF, RDFS_RANGE, RDFS_CLASS);

    //$desc->add_resource_triple(RDF_SUBJECT, RDFS_RANGE, RDFS_RESOURCE);
    //$desc->add_resource_triple(RDF_PREDICATE, RDFS_RANGE, RDFS_RESOURCE);
    //$desc->add_resource_triple(RDF_OBJECT, RDFS_RANGE, RDFS_RESOURCE);
    //$desc->add_resource_triple(RDFS_MEMBER, RDFS_RANGE, RDFS_RESOURCE);
    //$desc->add_resource_triple(RDF_FIRST, RDFS_RANGE, RDFS_RESOURCE);
    $desc->add_resource_triple(RDF_REST, RDFS_RANGE, RDF_LIST);
    //$desc->add_resource_triple(RDFS_SEEALSO, RDFS_RANGE, RDFS_RESOURCE);
    //$desc->add_resource_triple(RDFS_ISDEFINEDBY, RDFS_RANGE, RDFS_RESOURCE);
    //$desc->add_resource_triple(RDFS_COMMENT, RDFS_RANGE, RDFS_LITERAL);
    //$desc->add_resource_triple(RDFS_LABEL, RDFS_RANGE, RDFS_LITERAL);
    //$desc->add_resource_triple(RDF_VALUE, RDFS_RANGE, RDFS_RESOURCE);

    $desc->add_resource_triple(RDFS_ISDEFINEDBY, RDFS_SUBPROPERTYOF, RDFS_SEEALSO);
    $desc->add_resource_triple(OWL_OBJECTPROPERTY, RDFS_SUBCLASSOF, RDF_PROPERTY);
    $desc->add_resource_triple(OWL_DATATYPEPROPERTY, RDFS_SUBCLASSOF, RDF_PROPERTY);
    $desc->add_resource_triple(OWL_TRANSITIVEPROPERTY, RDFS_SUBCLASSOF, OWL_OBJECTPROPERTY);
    $desc->add_resource_triple(OWL_TRANSITIVEPROPERTY, RDFS_SUBCLASSOF, RDF_PROPERTY);
    $desc->add_resource_triple(OWL_SYMMETRICPROPERTY, RDFS_SUBCLASSOF, OWL_OBJECTPROPERTY);
    $desc->add_resource_triple(OWL_SYMMETRICPROPERTY, RDFS_SUBCLASSOF, RDF_PROPERTY);
    $desc->add_resource_triple(OWL_FUNCTIONALPROPERTY, RDFS_SUBCLASSOF, OWL_OBJECTPROPERTY);
    $desc->add_resource_triple(OWL_FUNCTIONALPROPERTY, RDFS_SUBCLASSOF, RDF_PROPERTY);
    $desc->add_resource_triple(OWL_INVERSEFUNCTIONALPROPERTY, RDFS_SUBCLASSOF, OWL_OBJECTPROPERTY);
    $desc->add_resource_triple(OWL_INVERSEFUNCTIONALPROPERTY, RDFS_SUBCLASSOF, RDF_PROPERTY);
    $desc->add_resource_triple(OWL_ANNOTATIONPROPERTY, RDFS_SUBCLASSOF, RDF_PROPERTY);

    $desc->add_resource_triple(OWL_CLASS, RDFS_SUBCLASSOF, RDFS_CLASS);
    $desc->add_resource_triple(OWL_EQUIVALENTCLASS, RDFS_DOMAIN, OWL_CLASS);
    $desc->add_resource_triple(OWL_EQUIVALENTCLASS, RDFS_DOMAIN, RDFS_CLASS);
    $desc->add_resource_triple(OWL_EQUIVALENTCLASS, RDFS_RANGE, OWL_CLASS);
    $desc->add_resource_triple(OWL_EQUIVALENTCLASS, RDFS_RANGE, RDFS_CLASS);

    $desc->add_resource_triple(OWL_COMPLEMENTOF, RDFS_DOMAIN, OWL_CLASS);
    $desc->add_resource_triple(OWL_COMPLEMENTOF, RDFS_DOMAIN, RDFS_CLASS);
    $desc->add_resource_triple(OWL_COMPLEMENTOF, RDFS_RANGE, OWL_CLASS);
    $desc->add_resource_triple(OWL_COMPLEMENTOF, RDFS_RANGE, RDFS_CLASS);

    $desc->add_resource_triple(OWL_DISJOINTWITH, RDFS_DOMAIN, OWL_CLASS);
    $desc->add_resource_triple(OWL_DISJOINTWITH, RDFS_DOMAIN, RDFS_CLASS);
    $desc->add_resource_triple(OWL_DISJOINTWITH, RDFS_RANGE, OWL_CLASS);
    $desc->add_resource_triple(OWL_DISJOINTWITH, RDFS_RANGE, RDFS_CLASS);

    $desc->add_resource_triple(OWL_INVERSEOF, RDFS_DOMAIN, OWL_OBJECTPROPERTY);
    $desc->add_resource_triple(OWL_INVERSEOF, RDFS_DOMAIN, RDF_PROPERTY);
    $desc->add_resource_triple(OWL_INVERSEOF, RDFS_RANGE, OWL_OBJECTPROPERTY);
    $desc->add_resource_triple(OWL_INVERSEOF, RDFS_RANGE, RDF_PROPERTY);

    $desc->add_resource_triple(OWL_EQUIVALENTPROPERTY, RDFS_SUBPROPERTYOF, RDFS_SUBPROPERTYOF);

    $desc->add_resource_triple(RDFS_ISDEFINEDBY, RDF_TYPE, OWL_ANNOTATIONPROPERTY);
    $desc->add_resource_triple(RDFS_ISDEFINEDBY, RDF_TYPE, RDF_PROPERTY);
    $desc->add_resource_triple(RDFS_COMMENT, RDF_TYPE, OWL_ANNOTATIONPROPERTY);
    $desc->add_resource_triple(RDFS_COMMENT, RDF_TYPE, RDF_PROPERTY);
    $desc->add_resource_triple(RDFS_LABEL, RDF_TYPE, OWL_ANNOTATIONPROPERTY);
    $desc->add_resource_triple(RDFS_LABEL, RDF_TYPE, RDF_PROPERTY);
    $desc->add_resource_triple(RDF_VALUE, RDF_TYPE, OWL_ANNOTATIONPROPERTY);
    $desc->add_resource_triple(RDF_VALUE, RDF_TYPE, RDF_PROPERTY);

    $desc->add_resource_triple(RDFS_SUBPROPERTYOF, RDF_TYPE, OWL_TRANSITIVEPROPERTY);
    $desc->add_resource_triple(RDFS_SUBCLASSOF, RDF_TYPE, OWL_TRANSITIVEPROPERTY);
    $desc->add_resource_triple(OWL_INVERSEOF, RDF_TYPE, OWL_SYMMETRICPROPERTY);
    $desc->add_resource_triple(OWL_DISJOINTWITH, RDF_TYPE, OWL_SYMMETRICPROPERTY);
    $desc->add_resource_triple(OWL_COMPLEMENTOF, RDF_TYPE, OWL_SYMMETRICPROPERTY);
    $desc->add_resource_triple(OWL_EQUIVALENTCLASS, RDF_TYPE, OWL_SYMMETRICPROPERTY);
    $desc->add_resource_triple(OWL_EQUIVALENTCLASS, RDF_TYPE, OWL_TRANSITIVEPROPERTY);
    $desc->add_resource_triple(OWL_SAMEAS, RDF_TYPE, OWL_SYMMETRICPROPERTY);
    $desc->add_resource_triple(OWL_SAMEAS, RDF_TYPE, OWL_TRANSITIVEPROPERTY);

  }
  
  function _process_subproperties(&$desc, &$property_index) {
    $inferred_properties = array();
    if (array_key_exists(RDFS_SUBPROPERTYOF, $property_index)) {
      foreach ($property_index[RDFS_SUBPROPERTYOF] as $so) {
        if (array_key_exists($so['s'], $property_index) ) {
          foreach ($property_index[$so['s']] as $so2) {
            if (! array_key_exists($so['o'], $inferred_properties)) {
              $inferred_properties[$so['o']] = array();
            }
            $inferred_properties[$so['o']][] = array('s'=>$so2['s'], 'o'=>$so2['o']);            
          }
        }
      }
    }  
    
    $this->_merge_inferred_properties($desc, $property_index, $inferred_properties);
  }    


  function _process_type_inference(&$desc, &$property_index) {    
    if (array_key_exists(RDFS_RANGE, $property_index)) {
      foreach ($property_index[RDFS_RANGE] as $so) {
        if (array_key_exists($so['s'], $property_index) ) {
          foreach ($property_index[$so['s']] as $so2) {
            $desc->add_resource_triple( $so2['o'], RDF_TYPE, $so['o']);
          }
        }
      }
    }

    if (array_key_exists(RDFS_DOMAIN, $property_index)) {
      foreach ($property_index[RDFS_DOMAIN] as $so) {
        if (array_key_exists($so['s'], $property_index) ) {
          foreach ($property_index[$so['s']] as $so2) {
            $desc->add_resource_triple( $so2['s'], RDF_TYPE, $so['o']);
          }
        }
      }
    }  

    if (array_key_exists(RDFS_SUBCLASSOF, $property_index)) {
      foreach ($property_index[RDFS_SUBCLASSOF] as $so) {
        if (array_key_exists(RDF_TYPE, $property_index) ) {
          foreach ($property_index[RDF_TYPE] as $so2) {
            if ( $so2['o'] == $so['s'] ) {
              $desc->add_resource_triple( $so2['s'], RDF_TYPE, $so['o']);
            }
          }
        }
      }
    }  
  }
  
  function _process_symmetric_properties(&$desc, &$property_index) {
    $inferred_properties = array();
    if (array_key_exists(RDF_TYPE, $property_index)) {
      foreach ($property_index[RDF_TYPE] as $so) {
        if ($so['o'] == OWL_SYMMETRICPROPERTY)  {
          $p = $so['s'];
          if (array_key_exists($p, $property_index)) {
            foreach ($property_index[$p] as $so2) {
              if (! array_key_exists($p, $inferred_properties)) {
                $inferred_properties[$p] = array();
              }
              $inferred_properties[$p][] = array('s'=>$so2['o'], 'o'=>$so2['s']);            
            }             
          }
          
        }

      }
    }
    
    $this->_merge_inferred_properties($desc, $property_index, $inferred_properties);
  }
  
  function _merge_inferred_properties(&$desc, &$property_index, &$inferred_properties) {
    foreach ($inferred_properties as $p => $so_list) {
      foreach( $so_list as $so) {
        if ($desc->add_resource_triple( $so['s'], $p, $so['o']) ) {
          if (! array_key_exists($p, $property_index)) {
            $property_index[$p] = array();
          }
          $property_index[$p][] = $so;
        }
      }
    }
  }

  function _process_transitive_properties(&$desc, &$property_index) {
    $inferred_properties = array();
    if (array_key_exists(RDF_TYPE, $property_index)) {
      foreach ($property_index[RDF_TYPE] as $so) {
        if ($so['o'] == OWL_TRANSITIVEPROPERTY)  {
          $p = $so['s'];
          if (array_key_exists($p, $property_index)) {
            $chains = array();
            foreach ($property_index[$p] as $so2) {
              if (!array_key_exists($so2['s'], $chains)) {
                $chains[$so2['s']] = array();
              } 
              $chains[$so2['s']][] = array($so2['o']);
            }
            $chains = $this->_extend_chains($chains);

            $inferred_properties[$p] = array();
            foreach ($chains as $s => $chain_list) {
              foreach ($chain_list as $chain) {
                for ($j = 1; $j < count($chain); $j++) {
                  //echo "Inferring <" . $s. "> <$p> <" . $chain[$j] . ">\n";
                  $inferred_properties[$p][] = array('s'=>$s, 'o'=>$chain[$j]);            
                }
                for ($i = 0; $i < count($chain) - 1; $i++) {
                  for ($j = $i + 2; $j < count($chain); $j++) {
                    //echo "Inferring <" . $chain[$i] . "> <$p> <" . $chain[$j] . ">\n";
                    $inferred_properties[$p][] = array('s'=>$chain[$i], 'o'=>$chain[$j]);            
                  }
                } 
              } 
            }
          }
          
        }

      }
    }
    
    $this->_merge_inferred_properties($desc, $property_index, $inferred_properties);
  }
  
  
  function _extend_chains(&$chains) {
    $new_chains = array();
    foreach ($chains as $s => $chain_list) {
//      echo "Starting with " . $s . "\n";
      foreach($chain_list as $chain) {
        $connecting_resource = $chain[count($chain) - 1];
        if ($connecting_resource != $s) {
//          echo "Looking if I can build a chain on " . $connecting_resource . "\n";
          if ( array_key_exists($connecting_resource, $chains) && count($chains[$connecting_resource]) > 1 ) {
//            echo $connecting_resource . " appears to be the start of a chain\n";
            if (!array_key_exists($s, $new_chains)) {
              $new_chains[$s] = array();
            } 
            foreach ($chains[$connecting_resource] as $tail) {
//              echo "Connecting $s to " . $tail[0] . "\n";
              $new_chains[$s][] = array_merge($chain,$tail);
            }
          }   
        }
      }
    }   

/* RECURSION IS PROBLEMATIC, NEEDS DEBUGGING    
    if ( count($new_chains) > 0 ) {
      return $this->_extend_chains($new_chains);
    }
    else {
*/
      return $chains; 
 /*
    }
*/
  }
  
}

