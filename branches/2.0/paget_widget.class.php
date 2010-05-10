<?php

class PAGET_Widget {
  var $ignore_properties = array();
  var $desc;
  var $template;
  var $inverse_index;
  var $urispace;
  
  function __construct(&$desc, $template, $urispace) {
    $this->desc = $desc;
    $this->template = $template;
    $this->urispace = $urispace;
    $this->inverse_index = $desc->get_inverse_index();
  }
  
  function get_title($resource_uri) {
    return $this->desc->get_label($resource_uri);
  }
  
  function render($resource_info, $inline = FALSE, $brief = FALSE) {
    if ($resource_info['type'] == 'literal') return $this->render_literal($resource_info, $inline);
    return render_brief($resource_info, $inline);
  }

  function render_brief($resource_info, $inline = FALSE) {
    if ($resource_info['type'] == 'literal') return $this->render_literal($resource_info, $inline);
    $html = '<div class="res">' . $this->link_uri($resource_info['value']);
    $comment = $this->desc->get_description($resource_info['value']);
    if (strlen($comment) > 0) {
      $html.= '<br />' . htmlspecialchars($comment);  
    }
    $html .= '</div>';
    return $html;
  }

  function render_literal($resource_info, $inline = FALSE, $brief = FALSE) {
    $html = '<div class="lit">';
    
    $value = $resource_info['value'];
    $encode_value = TRUE;
    if (isset($resource_info['datatype'])) {
      if ($resource_info['datatype'] == 'http://www.w3.org/2001/XMLSchema#date') {
        $datetime = strtotime($resource_info['value']);
        if ($datetime !== FALSE) {
          $value = date("j F Y", $datetime);
        }
      }
      else if ($resource_info['datatype'] == 'http://www.w3.org/1999/02/22-rdf-syntax-ns#XMLLiteral') {
        $encode_value = FALSE;
      }
    }

    if ($encode_value) {
      $html .= htmlspecialchars($value);
    }
    else {
      $html .= $value;
    }

    if (isset($resource_info['lang'])) {
      $html .= ' <span class="lang">[' . htmlspecialchars($resource_info['lang']) . ']</span>';
    }
    if (isset($resource_info['datatype'])) {
      //$html .= ' <span class="dt">[' . $this->link_uri($resource_info['datatype']) . ']</span>';
    }
    $html .= '</div>';
    return $html;
  }
  
  function e($text) {
    echo(htmlspecialchars($text));  
  } 

  function link_uri($uri, $label = '', $use_definite_article = false) {
    if (preg_match('/^_:/', $uri) ) {
      if ($label == '') {
        $label = $this->make_labelled_uri($uri);
      }
      return $label;
    }
    else if (preg_match('/^https?:\/\//', $uri) ) {
      $ret = '';
      if ($label == '') {
        $label = $this->make_labelled_uri($uri);
      }
      
      if ( $use_definite_article ) {
        $ret .= 'a';        
        if ( preg_match('/^(<[^>]+>)?[aeiou]/', $label) ) {
          $ret .= 'n';        
        }
        $ret .= ' ';
      }   

      $ret .= '<a href="' . htmlspecialchars($this->urispace->resource_uri_to_request_uri($uri)) . '" class="uri">';
      $ret .= $label . '</a>';
      return $ret;
    }
    else {
      return htmlspecialchars($uri);
    }
  }


  function make_labelled_uri($uri) {
    $title = $this->get_title($uri);
    if ($title != $uri) {
      return htmlspecialchars($title);
    }
    else {
      $qname = $this->desc->uri_to_qname($uri);
      if ($qname != null) {
        $m = split(':', $qname);  
        return '<span class="prefix">' . htmlspecialchars($m[0]) . ':</span><span class="localname">' . htmlspecialchars($m[1]) . '</span>';
      }  
    }
    return $uri;
  }
  

  function emit_key_value(&$data) {
    $ret = '';
    if ( count($data) > 0 ) {
      foreach ($data as $item) {
        $ret .= '<p><strong>' . $item['label'] . '</strong>: ' . $item['value'] . '</p>' . "\n";
      }   
    }
    
    return $ret;
  }
  
  function format_property_label($property, $label) {
    return '<span title="' .htmlspecialchars($property) . '">' . $this->link_uri($property, $label) . '</span>';
  }
  
  function format_property_values($property, &$property_values) {
    $formatted_value = '';
    
    for ($i = 0; $i < count($property_values); $i++) {
      if ($i > 0) {
        if ($i < count($property_values) - 1) {
          $formatted_value .= ', ';
        }
        else {
          $formatted_value .= ' and ';
        }
      }
      if ($property_values[$i]['type'] == 'uri') {
        $formatted_value .= $this->link_uri($property_values[$i]['value']);
        }
      else if ($property_values[$i]['type'] == 'bnode') {
        $formatted_value .= htmlspecialchars($this->get_title($property_values[$i]['value'])); 
      }
      else {
        $formatted_value .= htmlspecialchars($property_values[$i]['value']); 
      }
    }   

    return $formatted_value;
  }


  function emit_property_value_list($resource_uri, $properties) {
    $data = array();
    foreach ($properties as $property) {
      $property_values = $this->desc->get_subject_property_values($resource_uri, $property);
      if ( count($property_values) > 0) {
    
        if ( count($property_values) == 1) {
          $label = ucfirst($this->desc->get_first_literal($property, RDFS_LABEL));
        }
        else {
          $label = ucfirst($this->desc->get_first_literal($property, 'http://purl.org/net/vocab/2004/03/label#plural'));
        }         
        
        
        $formatted_label = $this->format_property_label($property, $label);
        $formatted_value = $this->format_property_values($property, $property_values);

        $data[] = array('label' => $formatted_label, 'value' => $formatted_value );
      }
    }
    
    if (array_key_exists($resource_uri, $this->inverse_index)) {
      foreach ($this->inverse_index[$resource_uri] as $property => $property_values) {
        $label = ucfirst($this->desc->get_first_literal($property, 'http://purl.org/net/vocab/2004/03/label#inverseSingular'));
        $formatted_label = $this->format_property_label($property, $label);
        $formatted_value = $this->format_property_values($property, $property_values);

        $data[] = array('label' => $formatted_label, 'value' => $formatted_value );
      }
    
    }    
    $this->emit_key_value($data);   
  }    


  function emit_image_properties($resource_uri, $properties) {
    $data = array();
    foreach ($properties as $property) {
      $property_values = $this->desc->get_subject_property_values($resource_uri, $property);
      if ( count($property_values) > 0) {
    
        if ( count($property_values) == 1) {
          $label = ucfirst($this->desc->get_first_literal($property, RDFS_LABEL));
        }
        else {
          $label = ucfirst($this->desc->get_first_literal($property, 'http://purl.org/net/vocab/2004/03/label#plural'));
        }         
        
        
        $formatted_label = $this->format_property_label($property, $label);
        
        foreach ($property_values as $property_value) {
          if ($property_value['type'] == 'uri') {
            $ret .= '<div style="float:right;"><a href="' . htmlspecialchars($this->urispace->resource_uri_to_request_uri($property_value['value']) ) . '"><img src="' . htmlspecialchars($property_value['value'] ) . '" /></a></div>' . "\n";
          }
        }       
      }
    }
    
  }    
  function ignore_properties($properties) {
    $this->ignore_properties = array_merge($this->ignore_properties, $properties);
  }
  
}
