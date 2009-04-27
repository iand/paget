<?php
class PAGET_SimplePropertyLabeller {
  var $_labels = array(
                      'http://www.w3.org/1999/02/22-rdf-syntax-ns#type' => array('singular' => 'type', 'plural' => 'types', 'inverse' => 'is type of'),
                      'http://www.w3.org/2000/01/rdf-schema#label' => array('singular' => 'label', 'plural' => 'labels', 'inverse' => 'is label of'),
                      'http://www.w3.org/2000/01/rdf-schema#comment' => array('singular' => 'comment', 'plural' => 'comments', 'inverse' => 'is comment of'),
                      'http://www.w3.org/2000/01/rdf-schema#seeAlso' => array('singular' => 'see also', 'plural' => 'see also', 'inverse' => 'is see also of'),
                      'http://www.w3.org/2000/01/rdf-schema#isDefinedBy' => array('singular' => 'defined by', 'plural' => 'defined by', 'inverse' => 'defines'),
                      'http://www.w3.org/2000/01/rdf-schema#range' => array('singular' => 'range', 'plural' => 'ranges', 'inverse' => 'is range of'),
                      'http://www.w3.org/2000/01/rdf-schema#domain' => array('singular' => 'domain', 'plural' => 'domains', 'inverse' => 'is domain of'),
                      'http://www.w3.org/2002/07/owl#imports' => array('singular' => 'imports', 'plural' => 'imports', 'inverse' => 'is imported by'),
                      'http://xmlns.com/foaf/0.1/isPrimaryTopicOf' => array('singular' => 'is the primary topic of', 'plural' => 'is the primary topic of', 'inverse' => 'primary topic'),
                      'http://xmlns.com/foaf/0.1/primaryTopic' => array('singular' => 'primary topic', 'plural' => 'primary topics', 'inverse' => 'is the primary topic of'),
                      'http://xmlns.com/foaf/0.1/topic' => array('singular' => 'topic', 'plural' => 'topics', 'inverse' => 'is a topic of'),
                      'http://xmlns.com/foaf/0.1/name' => array('singular' => 'name', 'plural' => 'names', 'inverse' => 'is name of'),
                      'http://xmlns.com/foaf/0.1/homepage' => array('singular' => 'homepage', 'plural' => 'homepages', 'inverse' => 'is homepage of'),
                      'http://xmlns.com/foaf/0.1/weblog' => array('singular' => 'blog', 'plural' => 'blogs', 'inverse' => 'is weblog of'),
                      'http://xmlns.com/foaf/0.1/knows' => array('singular' => 'knows', 'plural' => 'knows', 'inverse' => 'knows'),
                      'http://xmlns.com/foaf/0.1/interest' => array('singular' => 'interest', 'plural' => 'interests', 'inverse' => 'is interest of'),
                      'http://xmlns.com/foaf/0.1/firstName' => array('singular' => 'first name', 'plural' => 'first names', 'inverse' => 'is first name of'),
                      'http://xmlns.com/foaf/0.1/surname' => array('singular' => 'surname', 'plural' => 'surnames', 'inverse' => 'is surname of'),
                      'http://purl.org/dc/elements/1.1/title' => array('singular' => 'title', 'plural' => 'titles', 'inverse' => 'is the title of'),
                      'http://purl.org/dc/elements/1.1/description' => array('singular' => 'description', 'plural' => 'descriptions', 'inverse' => 'is description of'),
                      'http://purl.org/dc/elements/1.1/date' => array('singular' => 'date', 'plural' => 'dates', 'inverse' => 'is date of'),
                      'http://purl.org/dc/elements/1.1/identifier' => array('singular' => 'identifier', 'plural' => 'identifiers', 'inverse' => 'is identifier of'),
                      'http://purl.org/dc/elements/1.1/type' => array('singular' => 'document type', 'plural' => 'document types', 'inverse' => 'is document type of'),
                      'http://purl.org/dc/elements/1.1/contributor' => array('singular' => 'contributor', 'plural' => 'contributors', 'inverse' => 'is contributor to'),
                      'http://purl.org/dc/elements/1.1/rights' => array('singular' => 'rights statement', 'plural' => 'right statements', 'inverse' => 'is rights statement for'),
                      'http://purl.org/dc/elements/1.1/subject' => array('singular' => 'subject', 'plural' => 'subjects', 'inverse' => 'is subject for'),
                      'http://purl.org/dc/elements/1.1/publisher' => array('singular' => 'publisher', 'plural' => 'publishers', 'inverse' => 'is publisher of'),
                      'http://purl.org/dc/terms/isVersionOf' => array('singular' => 'version of', 'plural' => 'version of', 'inverse' => 'version'),
                      'http://purl.org/dc/terms/replaces' => array('singular' => 'replaces', 'plural' => 'replaces', 'inverse' => 'replaced by'),
                      'http://purl.org/dc/terms/title' => array('singular' => 'title', 'plural' => 'titles', 'inverse' => 'is the title of'),
                      'http://purl.org/dc/terms/description' => array('singular' => 'description', 'plural' => 'descriptions', 'inverse' => 'is description of'),
                      'http://purl.org/dc/terms/date' => array('singular' => 'date', 'plural' => 'dates', 'inverse' => 'is date of'),
                      'http://purl.org/dc/terms/identifier' => array('singular' => 'identifier', 'plural' => 'identifiers', 'inverse' => 'is identifier of'),
                      'http://purl.org/dc/terms/type' => array('singular' => 'document type', 'plural' => 'document types', 'inverse' => 'is document type of'),
                      'http://purl.org/dc/terms/contributor' => array('singular' => 'contributor', 'plural' => 'contributors', 'inverse' => 'is contributor to'),
                      'http://purl.org/dc/terms/rights' => array('singular' => 'rights statement', 'plural' => 'right statements', 'inverse' => 'is rights statement for'),
                      'http://purl.org/dc/terms/issued' => array('singular' => 'issued', 'plural' => 'issued', 'inverse' => 'is issued of'),
                      'http://purl.org/dc/terms/updated' => array('singular' => 'updated', 'plural' => 'updated', 'inverse' => 'is updated of'),
                      'http://purl.org/dc/terms/source' => array('singular' => 'source', 'plural' => 'sources', 'inverse' => 'is source of'),
                      'http://purl.org/dc/terms/subject' => array('singular' => 'subject', 'plural' => 'subjects', 'inverse' => 'is subject of'),
                      'http://purl.org/dc/terms/language' => array('singular' => 'language', 'plural' => 'languages', 'inverse' => 'is language of'),
                      'http://purl.org/dc/terms/publisher' => array('singular' => 'publisher', 'plural' => 'publishers', 'inverse' => 'is publisher of'),
                      'http://www.w3.org/2003/01/geo/wgs84_pos#lat' => array('singular' => 'latitude', 'plural' => 'latitudes', 'inverse' => 'is latitude of'),
                      'http://www.w3.org/2003/01/geo/wgs84_pos#long' => array('singular' => 'longitude', 'plural' => 'longitudes', 'inverse' => 'is longitude of'),
                      'http://www.w3.org/2002/07/owl#sameAs' => array('singular' => 'same as', 'plural' => 'same as', 'inverse' => 'same as'),
                      'http://purl.org/vocab/bio/0.1/olb' => array('singular' => 'one line bio', 'plural' => 'one line bios', 'inverse' => 'is one line bio of'),
                      'http://purl.org/vocab/relationship/parentOf' => array('singular' => 'is parent of', 'plural' => 'is parent of', 'inverse' => 'is child of'),
                      'http://purl.org/vocab/relationship/childOf' => array('singular' => 'is child of', 'plural' => 'is child of', 'inverse' => 'is parent of'),
                      'http://purl.org/vocab/vann/example' => array('singular' => 'example', 'plural' => 'examples', 'inverse' => 'is example for'),
                      'http://purl.org/vocab/vann/preferredNamespacePrefix' => array('singular' => 'preferred namespace prefix', 'plural' => 'preferred namespace prefixes', 'inverse' => 'is preferred namespace prefix for'),
                      'http://purl.org/vocab/vann/preferredNamespaceUri' => array('singular' => 'preferred namespace URI', 'plural' => 'preferred namespace URIs', 'inverse' => 'is preferred namespace URI for'),
                      'http://purl.org/vocab/vann/changes' => array('singular' => 'change log', 'plural' => 'change logs', 'inverse' => 'is change log of'),
                      'http://www.w3.org/2004/02/skos/core#prefLabel' => array('singular' => 'preferred label', 'plural' => 'preferred labels', 'inverse' => 'is preferred label of'),
                      'http://www.w3.org/2004/02/skos/core#member' => array('singular' => 'member', 'plural' => 'members', 'inverse' => 'is a member of'),
                      'http://www.w3.org/2004/02/skos/core#related' => array('singular' => 'related to', 'plural' => 'related to', 'inverse' => 'related to'),
                      'http://www.w3.org/2004/02/skos/core#definition' => array('singular' => 'definition', 'plural' => 'definitions', 'inverse' => 'is definition of'),
                      'http://www.w3.org/2004/02/skos/core#context' => array('singular' => 'context', 'plural' => 'contexts', 'inverse' => 'is context of'),
                      'http://rdfs.org/ns/void#exampleResource' => array('singular' => 'example resource', 'plural' => 'example resources', 'inverse' => 'is example resource of'),
                      'http://rdfs.org/ns/void#sparqlEndpoint' => array('singular' => 'SPARQL endpoint', 'plural' => 'SPARQL endpoints', 'inverse' => 'is SPARQL endpoint of'),
                      'http://open.vocab.org/terms/subtitle' => array('singular' => 'sub-title', 'plural' => 'sub-titles', 'inverse' => 'is sub-title of'),


                );          
                
                
                                               
  function __construct() {

  }
  
  function process(&$desc) {
    $labelled_properties = array();
    $index = $desc->get_index();
    foreach ($index as $s => $p_list) {
      foreach ($p_list as $p => $val) {
        if ( !array_key_exists($p, $labelled_properties) ) {
          
          if ( array_key_exists($p, $this->_labels) ) {
            if ( ! $desc->subject_has_property($p, RDFS_LABEL) ) {
              $desc->add_literal_triple($p, RDFS_LABEL, $this->_labels[$p]['singular']);
            }
            if ( ! $desc->subject_has_property($p, 'http://purl.org/net/vocab/2004/03/label#plural') ) {
              $desc->add_literal_triple($p, 'http://purl.org/net/vocab/2004/03/label#plural', $this->_labels[$p]['plural']);
            }
            if ( ! $desc->subject_has_property($p, 'http://purl.org/net/vocab/2004/03/label#inverseSingular') ) {
              $desc->add_literal_triple($p, 'http://purl.org/net/vocab/2004/03/label#inverseSingular', $this->_labels[$p]['inverse']);
            }
            $labelled_properties[$p] = 1;
          }
          else if (preg_match('~^http://www.w3.org/1999/02/22-rdf-syntax-ns#_(.+)$~', $p, $m)) {
            $desc->add_literal_triple($p, RDFS_LABEL, 'Item ' . $m[1]);
            $labelled_properties[$p] = 1;
          }     
        }
      }
    }
    

  }

}
