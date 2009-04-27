<?
include_once "paget_termwidget.class.php";
include_once "paget_datawidget.class.php";
include_once "paget_tabledatawidget.class.php";
include_once "paget_historywidget.class.php";
include_once "paget_ontologywidget.class.php";
include_once "paget_rsswidget.class.php";
include_once "paget_seqwidget.class.php";
include_once "paget_bagwidget.class.php";


class PAGET_Template {
  var $desc;
  var $excludes;
  function __construct($desc) {
    $this->desc = $desc;  

    $this->table_widget = new PAGET_TableDataWidget($this->desc, $this);
    $this->seq_widget = new PAGET_SeqWidget($this->desc, $this);
    $this->bag_widget = new PAGET_BagWidget($this->desc, $this);
    $this->rss_widget = new PAGET_RSSWidget($this->desc, $this);
    $this->ontology_widget = new PAGET_OntologyWidget($this->desc, $this);
    $this->term_widget = new PAGET_TermWidget($this->desc, $this);

  }

  function get_title($resource_uri = null) {
    return $this->desc->get_label($resource_uri, $this);
  }  

  function render($resource_info, $inline = FALSE, $brief = FALSE) {

    if ($resource_info['type'] == 'bnode' || $resource_info['type'] == 'uri') {
      $resource_uri = $resource_info['value'];
      if ( $this->desc->has_resource_triple($resource_uri, RDF_TYPE, RDF_PROPERTY) || $this->desc->has_resource_triple($resource_uri, RDF_TYPE, RDFS_CLASS) ) {
        $widget = $this->term_widget;
      }
      else if ( $this->desc->has_resource_triple($resource_uri, RDF_TYPE, 'http://www.w3.org/2002/07/owl#Ontology')  ) {
        $widget = $this->ontology_widget;
      }
      else if ( $this->desc->has_resource_triple($resource_uri, RDF_TYPE, 'http://purl.org/rss/1.0/channel')  ) {
        $widget = $this->rss_widget;
      }
      else if ( $this->desc->has_resource_triple($resource_uri, RDF_TYPE, 'http://www.w3.org/1999/02/22-rdf-syntax-ns#Seq')  ) {
        $widget = $this->seq_widget;
      }
      else if ( $this->desc->has_resource_triple($resource_uri, RDF_TYPE, 'http://www.w3.org/1999/02/22-rdf-syntax-ns#Bag')  ) {
        $widget = $this->bag_widget;
      }
      else {
        $widget = $this->table_widget;
      }  
      return $widget->render($resource_info, $inline, $brief);
    }
    else {
      return htmlspecialchars($resource_info['value']);
    }
  }



  function exclude($resource_uri, $property_uri) {
    $this->excludes[$resource_uri . ' ' . $property_uri] = 1;
  }

  function is_excluded($resource_uri, $property_uri) {
    return array_key_exists($resource_uri . ' ' . $property_uri, $this->excludes);
  }

}
