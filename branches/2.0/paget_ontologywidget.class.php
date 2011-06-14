<?php
require_once "paget_widget.class.php";
require_once MORIARTY_DIR . "httprequest.class.php";

class PAGET_OntologyWidget extends PAGET_Widget {


  function render($resource_info, $inline = FALSE, $brief = FALSE, $level = 1) {


    if ($brief) return $this->render_brief($resource_info, $inline);
    $resource_uri = $resource_info['value'];
    $ret = '';

    $inline = array();

    $index = $this->desc->get_index();

    $people_info = array();
    $people_info[] = $this->render_dl_item($index, $resource_uri, array(DC_CREATOR, 'http://purl.org/dc/terms/creator', 'http://xmlns.com/foaf/0.1/maker'), 'Creator', 'Creators');
    $people_info[] = $this->render_dl_item($index, $resource_uri, array('http://purl.org/dc/elements/1.1/contributor', 'http://purl.org/dc/terms/contributor'), 'Contributor', 'Contributors');
    $people_info[] = $this->render_dl_item($index, $resource_uri, array('http://purl.org/dc/elements/1.1/source', 'http://purl.org/dc/terms/source'), 'Source', 'Sources');
    if (count($people_info) > 0) {
      $ret .= '<dl class="doc-info">' . join('', $people_info) . '</dl>';
    }

    $abstracts = $this->desc->get_literal_triple_values($resource_uri, array('http://purl.org/dc/terms/abstract'));
    if (count($abstracts) > 0) {
      foreach ($abstracts as $abstract) {
        $ret .=  '<p class="abstract">' . htmlspecialchars($abstract) . '</p>';
      }
    }

    $descriptions = $this->desc->get_subject_property_values($resource_uri, array('http://purl.org/dc/terms/description', DC_DESCRIPTION, RDFS_COMMENT));
    if (count($descriptions) > 0) {
      foreach ($descriptions as $description) {
        $ret .=  $this->template->render($description);        
      }
    }

    if ( $this->desc->subject_has_property($resource_uri, 'http://open.vocab.org/terms/discussionList') ) {
      $discussion_list = $this->desc->get_first_resource($resource_uri, 'http://open.vocab.org/terms/discussionList');
      $discussion_list_label = $this->desc->get_label($discussion_list);
      if ($discussion_list_label == $discussion_list) {
        $discussion_list_label = 'mailing list';
      }
      $ret .= sprintf('<p>Please direct feedback on this document to the <a href="%s">%s</a></p>' . "\n", htmlspecialchars($discussion_list), htmlspecialchars( $discussion_list_label ) );
    }

    $seealsos = $this->render_dl_item($index, $resource_uri, array(RDFS_SEEALSO), 'See also', 'See also');
    if ($seealsos) {
      $ret .= $seealsos;
    }


    if ( $this->desc->subject_has_property($resource_uri, 'http://purl.org/dc/elements/1.1/rights') || $this->desc->subject_has_property($resource_uri, 'http://purl.org/dc/terms/rights') ) {
      $ret .= '<p>' . htmlspecialchars($this->desc->get_first_literal($resource_uri, array('http://purl.org/dc/elements/1.1/rights', 'http://purl.org/dc/terms/rights'))) . '</p>' . "\n";
    }

    $history = '';
    if ( $this->desc->subject_has_property($resource_uri, 'http://www.w3.org/2004/02/skos/core#changeNote') || $this->desc->subject_has_property($resource_uri, 'http://www.w3.org/2004/02/skos/core#historyNote' ) || $this->desc->subject_has_property($resource_uri, 'http://purl.org/dc/terms/issued' ) ) {
      $history_widget = new PAGET_HistoryWidget($this->desc, $this->template, $this->urispace);
      $history .= $history_widget->render($resource_info, FALSE, FALSE, $level + 1);
      if (strlen($history) > 0) {
        $ret .=  '<h' . ($level + 1) . ' id="sec-history">History</h' . ($level + 1) . '>'. $history;
      }
    }


    $inverse_index = $this->desc->get_inverse_index();
    $def_uri = '';
    if (array_key_exists($resource_uri, $inverse_index) && array_key_exists(RDFS_ISDEFINEDBY, $inverse_index[$resource_uri])) {
      $def_uri =  $resource_uri;
    }
    else if (array_key_exists($resource_uri . '/', $inverse_index) && array_key_exists(RDFS_ISDEFINEDBY, $inverse_index[$resource_uri . '/'])) {
      $def_uri =  $resource_uri . '/';
    }
    else if (array_key_exists($resource_uri . '#', $inverse_index) && array_key_exists(RDFS_ISDEFINEDBY, $inverse_index[$resource_uri . '#'])) {
      $def_uri =  $resource_uri . '#';
    }

    $term_list = array();
    $property_list= array();
    $class_list= array();

    if (strlen($def_uri) > 0) {

      $terms = $inverse_index[$def_uri][RDFS_ISDEFINEDBY];
      if  (count($terms) > 0) {
        $tw = new PAGET_TermWidget($this->desc, $this->template, $this->urispace);
        $tw->ignore_properties(array(RDFS_ISDEFINEDBY, RDFS_SEEALSO));
        foreach ($terms as $v_info) {
          if ( $v_info['type'] == 'uri' ) {
            $term_uri = $v_info['value'];
            $term_label = $tw->get_title($term_uri);
            $term_desc = $tw->get_description($term_uri, TRUE);
            $term_id = $this->localname($term_uri);
            $term_list[$term_label] = array( 'html' => $tw->render($v_info, TRUE, FALSE, $level + 2),
                                                                  'uri' => $term_uri ,
                                                                  'label' => $term_label,
                                                                  'desc' => $term_desc,
                                                                  'id'=>$term_id,
                                                                );
          }
        }
      }
    }
    if (count($term_list)  > 0) {
      ksort( $term_list );
    }


    if ( $this->desc->subject_has_property($resource_uri, 'http://purl.org/vocab/vann/preferredNamespaceUri') || $this->desc->subject_has_property($resource_uri, 'http://purl.org/vocab/vann/preferredNamespacePrefix' ) ) {
      $ret .= '<h' . ($level + 1) . ' id="sec-namespace">Namespace</h' . ($level + 1) . '>' . "\n";
      if ( $this->desc->subject_has_property($resource_uri, 'http://purl.org/vocab/vann/preferredNamespaceUri') ) {
        $ret .= '<p>The URI for this vocabulary is </p><pre><code>'. htmlspecialchars($this->desc->get_first_literal($resource_uri, 'http://purl.org/vocab/vann/preferredNamespaceUri')) . '</code></pre>' . "\n";
      }
      if ( $this->desc->subject_has_property($resource_uri, 'http://purl.org/vocab/vann/preferredNamespacePrefix') ) {
        $ret .= '<p>When abbreviating terms the suggested prefix is <code>'. htmlspecialchars($this->desc->get_first_literal($resource_uri, 'http://purl.org/vocab/vann/preferredNamespacePrefix')) . '</code>' . "\n";
      }

      $ret .= '<p>Each class or property in the vocabulary has a URI constructed by appending a term name to the vocabulary URI. For example:</p><pre><code>' . htmlspecialchars($term_list[array_rand($term_list)]['uri']) . '</code></pre>' . "\n";
    }

    if ( $this->desc->subject_has_property($resource_uri, 'http://purl.org/vocab/vann/termGroup') ) {
      $ret .=  '<h' . ($level + 1) . '>Terms Grouped by Theme</h' . ($level + 1) . '>' . "\n";
      foreach ($index[$resource_uri]['http://purl.org/vocab/vann/termGroup'] as $v_info) {
        $title = $this->desc->get_first_literal($v_info['value'], array(RDFS_LABEL, DC_TITLE), 'Group', 'en');
        $ret .=  '<p>' . htmlspecialchars($title) . ': ';
        
        $props = $this->desc->get_subject_properties($v_info['value'], TRUE);
        $list_items = array();
        foreach ($props as $prop) {
          if ( preg_match("~^http://www.w3.org/1999/02/22-rdf-syntax-ns#_(\d+)$~", $prop, $m)) {
            $list_items[$m[1]] = array('property' => $prop, 'values' => $this->desc->get_subject_property_values($v_info['value'], $prop));
          }
        }
        $tw = new PAGET_TermWidget($this->desc, $this->template, $this->urispace);
        
        $list_values = array();
        foreach ($list_items as $number => $values) {
          foreach ($values['values'] as $value_info) {
            $list_values[] = array('label' => $tw->get_title($value_info['value']), 'id' => $this->localname($value_info['value']));
          }
        }
        for ($i = 0; $i < count($list_values); $i++) {
          if ($i > 0) {
            if ($i < count($list_values) - 1) {
              $ret .= ', ';
            }
            else {
              $ret .= ' and ';
            }
          }           
          $ret .= '<a href="#' . htmlspecialchars($list_values[$i]['id']) . '">' . htmlspecialchars($list_values[$i]['label']) . '</a>';
        
        }
        $ret .= '</p>';
      }
    }
    
    if (count($term_list) > 2) {
      $ret .=  '<h' . ($level + 1) . ' id="sec-summary">Term Summary</h' . ($level + 1) . '>' . "\n";
      $ret .= '<p>An alphabetical list of all terms defined in this schema.</p>' . "\n";
      $ret .= '<table><tr><th>Term</th><th>URI</th><th>Description</th></tr>' . "\n";
      foreach ($term_list as $term_info) {
        $ret .= '<tr><td>';
        if ($term_info['id'] != null) {
           $ret .= '<a href="#' . htmlspecialchars($term_info['id']) . '">' . htmlspecialchars($term_info['label']) . '</a>';
        }
        else {
          $ret .= htmlspecialchars($term_info['label']);
        }
        $ret .= '</td><td nowrap="nowrap">' . htmlspecialchars($term_info['uri']) .'</td>'. "\n";
        $desc = $term_info['desc'];
        $stoppos = strpos($desc, '.');
        if ($stoppos >0) {
          $desc = substr($desc, 0, $stoppos + 1);
        }
        $ret .= '<td>' . htmlspecialchars($desc) .'</td></tr>'. "\n";
      }
      $ret .= '</table>' . "\n";
    }



    if (count($term_list)  > 0) {
      $ret .=  '<h' . ($level + 1) . ' id="sec-terms">Properties and Classes</h' . ($level + 1) . '>' . "\n";
      foreach ($term_list as $term_info) {
        $term_id_fragment = '';
        if ($term_info['id'] != null) {
          $term_id_fragment = ' id="' . htmlspecialchars($term_info['id']) . '"';
        }
        $ret .= '<h' . ($level + 2)  . $term_id_fragment . '>' .htmlspecialchars( $term_info['label']) . '</h' . ($level + 2)  . '>';
        $ret .=  $term_info['html'] . "\n";
      }
    }





    if ( $this->desc->subject_has_property($resource_uri, 'http://purl.org/vocab/vann/example')) {
      $ret .=  '<h' . ($level + 1) . ' id="sec-examples">Examples</h' . ($level + 1) . '>';
      foreach ($index[$resource_uri]['http://purl.org/vocab/vann/example'] as $v_info) {
        $title = $this->desc->get_first_literal($v_info['value'], array(RDFS_LABEL, DC_TITLE), 'Example', 'en');
        $comment = $this->desc->get_first_literal($v_info['value'], array(RDFS_COMMENT), '', 'en');
        if ($comment) {
          $ret .=  '<h' . ($level + 2) . '>' . htmlspecialchars($title) . '</h' . ($level + 2) . '>';
          $ret .=  $comment;
        }
        else {
          $ret .=  $this->template->render($v_info);
        }

/*
          if ( $p == 'http://purl.org/vocab/vann/example' && $v_info['type'] == 'uri') {
            $title = $this->desc->get_first_literal($v_info['value'], array(RDFS_LABEL, DC_TITLE), 'Example', 'en');
            $ret .=  '<iframe src="'  . $this->link_uri($v_info['value'], $title) . '</li>';
          }
          else {
*/
//            $ret .=  '<div style="width:100%;"><iframe src="'  . htmlspecialchars($v_info['value']). '"  style="width:100%; border:0px;"></iframe></div>';
/*
          }
*/
      }
    }


    $data_widget = new PAGET_TableDataWidget($this->desc, $this->template, $this->urispace);
    $data_widget->ignore_properties(array(RDF_TYPE, DC_TITLE, 'http://purl.org/dc/terms/title', RDFS_LABEL, RDFS_SEEALSO, DC_DESCRIPTION, 'http://purl.org/dc/terms/abstract', 'http://purl.org/dc/terms/description', RDFS_COMMENT, 'http://purl.org/vocab/vann/example'));
    $data_widget->ignore_properties(array(DC_CREATOR, 'http://purl.org/dc/terms/creator', 'http://purl.org/dc/terms/contributor'));
    $data_widget->ignore_properties(array('http://purl.org/vocab/vann/preferredNamespaceUri', 'http://purl.org/vocab/vann/preferredNamespacePrefix', 'http://purl.org/dc/elements/1.1/rights', 'http://purl.org/dc/terms/rights', ));
    $data_widget->ignore_properties(array('http://www.w3.org/2004/02/skos/core#changeNote', 'http://www.w3.org/2004/02/skos/core#historyNote', 'http://purl.org/dc/terms/issued'));
    $data_widget->ignore_properties(array('http://purl.org/vocab/vann/termGroup', 'http://open.vocab.org/terms/discussionList', 'http://purl.org/dc/terms/identifier', 'http://purl.org/dc/terms/date'));
    $other = $data_widget->render($resource_info, FALSE, FALSE, $level + 2);
    if (strlen(trim($other)) > 0) {
      $ret .=  '<h' . ($level + 1) . '>Other Information</h' . ($level + 1) . '>' . $other;
    }


    return $ret;
  }

  function render_dl_item(&$index, $resource_uri, $properties, $singular_label, $plural_label) {
    if (!array_key_exists($resource_uri, $index)) return;
    $items = array();
    $ret = '';
    foreach ($properties as $p) {
      if (array_key_exists($p, $index[$resource_uri])) {
        foreach ($index[$resource_uri][$p] as $property_info) {
          $items[] = '<dd>' . $this->template->render($property_info, FALSE, TRUE) . '</dd>';
        }
      }
    }

    if (count($items) > 0) {
      $ret .= '<dt>';
      if (count($items) > 1) {
        $ret .= $plural_label;
      }
      else {
        $ret .= $singular_label;
      }
      $ret .= '</dt>' . join('', $items);
    }

    return $ret;
  }

  function localname($uri) {
    if (preg_match('~^(.*[\/\#])([a-z0-9\-\_]+)$~i', $uri, $m)) {
      return $m[2];
    }
    return null;
  }


}
