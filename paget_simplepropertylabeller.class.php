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
                      'http://xmlns.com/foaf/0.1/depiction' => array('singular' => 'picture', 'plural' => 'pictures', 'inverse' => 'is picture of'),
                      'http://purl.org/dc/elements/1.1/title' => array('singular' => 'title', 'plural' => 'titles', 'inverse' => 'is the title of'),
                      'http://purl.org/dc/elements/1.1/description' => array('singular' => 'description', 'plural' => 'descriptions', 'inverse' => 'is description of'),
                      'http://purl.org/dc/elements/1.1/date' => array('singular' => 'date', 'plural' => 'dates', 'inverse' => 'is date of'),
                      'http://purl.org/dc/elements/1.1/identifier' => array('singular' => 'identifier', 'plural' => 'identifiers', 'inverse' => 'is identifier of'),
                      'http://purl.org/dc/elements/1.1/type' => array('singular' => 'document type', 'plural' => 'document types', 'inverse' => 'is document type of'),
                      'http://purl.org/dc/elements/1.1/contributor' => array('singular' => 'contributor', 'plural' => 'contributors', 'inverse' => 'is contributor to'),
                      'http://purl.org/dc/elements/1.1/rights' => array('singular' => 'rights statement', 'plural' => 'right statements', 'inverse' => 'is rights statement for'),
                      'http://purl.org/dc/elements/1.1/subject' => array('singular' => 'subject', 'plural' => 'subjects', 'inverse' => 'is subject for'),
                      'http://purl.org/dc/elements/1.1/publisher' => array('singular' => 'publisher', 'plural' => 'publishers', 'inverse' => 'is publisher of'),
                      'http://purl.org/dc/elements/1.1/creator' => array('singular' => 'creator', 'plural' => 'creators', 'inverse' => 'is creator of'),

                      'http://purl.org/dc/terms/abstract' => array('singular' => 'abstract', 'plural' => 'abstracts', 'inverse' => 'is abstract of'),
                      'http://purl.org/dc/terms/accessRights' => array('singular' => 'access rights', 'plural' => 'access rights', 'inverse' => 'are access rights for'),
                      'http://purl.org/dc/terms/alternative' => array('singular' => 'alternative title', 'plural' => 'alternative titles', 'inverse' => 'is alternative title for'),
                      'http://purl.org/dc/terms/audience' => array('singular' => 'audience', 'plural' => 'audiences', 'inverse' => 'is audience for'),
                      'http://purl.org/dc/terms/available' => array('singular' => 'date available', 'plural' => 'dates available', 'inverse' => 'is date available of'),
                      'http://purl.org/dc/terms/bibliographicCitation' => array('singular' => 'bibliographic citation', 'plural' => 'bibliographic citations', 'inverse' => 'is bibliographic citation of'),
                      'http://purl.org/dc/terms/contributor' => array('singular' => 'contributor', 'plural' => 'contributors', 'inverse' => 'is contributor to'),
                      'http://purl.org/dc/terms/coverage' => array('singular' => 'coverage', 'plural' => 'coverage', 'inverse' => 'is coverage of'),
                      'http://purl.org/dc/terms/creator' => array('singular' => 'creator', 'plural' => 'creators', 'inverse' => 'is creator of'),
                      'http://purl.org/dc/terms/date' => array('singular' => 'date', 'plural' => 'dates', 'inverse' => 'is date of'),
                      'http://purl.org/dc/terms/dateAccepted' => array('singular' => 'date accepted', 'plural' => 'dates accepted', 'inverse' => 'is date accepted of'),
                      'http://purl.org/dc/terms/dateCopyrighted' => array('singular' => 'date copyrighted', 'plural' => 'dates copyrighted', 'inverse' => 'is date copyrighted of'),
                      'http://purl.org/dc/terms/dateSubmitted' => array('singular' => 'date submitted', 'plural' => 'dates submitted', 'inverse' => 'is date submitted of'),
                      'http://purl.org/dc/terms/description' => array('singular' => 'description', 'plural' => 'descriptions', 'inverse' => 'is description of'),
                      'http://purl.org/dc/terms/format' => array('singular' => 'format', 'plural' => 'formats', 'inverse' => 'is format of'),
                      'http://purl.org/dc/terms/hasPart' => array('singular' => 'has part', 'plural' => 'has parts', 'inverse' => 'is part of'),
                      'http://purl.org/dc/terms/hasVersion' => array('singular' => 'version', 'plural' => 'versions', 'inverse' => 'version of'),
                      'http://purl.org/dc/terms/identifier' => array('singular' => 'identifier', 'plural' => 'identifiers', 'inverse' => 'is identifier of'),
                      'http://purl.org/dc/terms/isPartOf' => array('singular' => 'part of', 'plural' => 'part of', 'inverse' => 'part'),
                      'http://purl.org/dc/terms/isReferencedBy' => array('singular' => 'is referenced by', 'plural' => 'is referenced by', 'inverse' => 'references'),
                      'http://purl.org/dc/terms/isReplacedBy' => array('singular' => 'is replaced by', 'plural' => 'is replaced by', 'inverse' => 'replaces'),
                      'http://purl.org/dc/terms/isRequiredBy' => array('singular' => 'is required by', 'plural' => 'is required by', 'inverse' => 'requires'),
                      'http://purl.org/dc/terms/issued' => array('singular' => 'date issued', 'plural' => 'dates issued', 'inverse' => 'is date issued of'),
                      'http://purl.org/dc/terms/isVersionOf' => array('singular' => 'version of', 'plural' => 'version of', 'inverse' => 'version'),
                      'http://purl.org/dc/terms/language' => array('singular' => 'language', 'plural' => 'languages', 'inverse' => 'is language of'),
                      'http://purl.org/dc/terms/license' => array('singular' => 'license', 'plural' => 'licenses', 'inverse' => 'is license of'),
                      'http://purl.org/dc/terms/medium' => array('singular' => 'medium', 'plural' => 'media', 'inverse' => 'is medium of'),
                      'http://purl.org/dc/terms/provenance' => array('singular' => 'provenance', 'plural' => 'provenances', 'inverse' => 'is provenance of'),
                      'http://purl.org/dc/terms/publisher' => array('singular' => 'publisher', 'plural' => 'publishers', 'inverse' => 'is publisher of'),
                      'http://purl.org/dc/terms/replaces' => array('singular' => 'replaces', 'plural' => 'replaces', 'inverse' => 'replaced by'),
                      'http://purl.org/dc/terms/references' => array('singular' => 'references', 'plural' => 'references', 'inverse' => 'is referenced by'),
                      'http://purl.org/dc/terms/relation' => array('singular' => 'relation', 'plural' => 'relations', 'inverse' => 'relation'),
                      'http://purl.org/dc/terms/replaces' => array('singular' => 'replaces', 'plural' => 'replaces', 'inverse' => 'is replaced by'),
                      'http://purl.org/dc/terms/requires' => array('singular' => 'requires', 'plural' => 'requires', 'inverse' => 'is required by'),
                      'http://purl.org/dc/terms/rights' => array('singular' => 'rights statement', 'plural' => 'right statements', 'inverse' => 'is rights statement for'),
                      'http://purl.org/dc/terms/rightsHolder' => array('singular' => 'rights holder', 'plural' => 'rights holders', 'inverse' => 'is rights holder of'),
                      'http://purl.org/dc/terms/source' => array('singular' => 'source', 'plural' => 'sources', 'inverse' => 'is source of'),
                      'http://purl.org/dc/terms/subject' => array('singular' => 'subject', 'plural' => 'subjects', 'inverse' => 'is subject of'),
                      'http://purl.org/dc/terms/tableOfContents' => array('singular' => 'table of contents', 'plural' => 'tables of contents', 'inverse' => 'is table of contents of'),
                      'http://purl.org/dc/terms/title' => array('singular' => 'title', 'plural' => 'titles', 'inverse' => 'is the title of'),
                      'http://purl.org/dc/terms/type' => array('singular' => 'document type', 'plural' => 'document types', 'inverse' => 'is document type of'),
                      'http://purl.org/dc/terms/updated' => array('singular' => 'date updated', 'plural' => 'dates updated', 'inverse' => 'is date updated of'),
                      'http://purl.org/dc/terms/valid' => array('singular' => 'date valid', 'plural' => 'dates valid', 'inverse' => 'is date valid of'),

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
                      'http://www.w3.org/2004/02/skos/core#altLabel' => array('singular' => 'alternative label', 'plural' => 'alternative labels', 'inverse' => 'is alternative label of'),
                      'http://www.w3.org/2004/02/skos/core#hiddenLabel' => array('singular' => 'hidden label', 'plural' => 'hidden labels', 'inverse' => 'is hidden label of'),
                      'http://www.w3.org/2004/02/skos/core#member' => array('singular' => 'member', 'plural' => 'members', 'inverse' => 'is a member of'),
                      'http://www.w3.org/2004/02/skos/core#related' => array('singular' => 'related concept', 'plural' => 'related concepts', 'inverse' => 'is related concept of'),
                      'http://www.w3.org/2004/02/skos/core#definition' => array('singular' => 'definition', 'plural' => 'definitions', 'inverse' => 'is definition of'),
                      'http://www.w3.org/2004/02/skos/core#context' => array('singular' => 'context', 'plural' => 'contexts', 'inverse' => 'is context of'),
                      'http://www.w3.org/2004/02/skos/core#broader' => array('singular' => 'broader concept', 'plural' => 'broader concepts', 'inverse' => 'narrower concept'),
                      'http://www.w3.org/2004/02/skos/core#narrower' => array('singular' => 'narrower concept', 'plural' => 'narrower concepts', 'inverse' => 'broader concept'),
                      'http://www.w3.org/2004/02/skos/core#note' => array('singular' => 'note', 'plural' => 'notes', 'inverse' => 'is note of'),
                      'http://www.w3.org/2004/02/skos/core#scopeNote' => array('singular' => 'scope note', 'plural' => 'scope notes', 'inverse' => 'is scope note of'),
                      'http://www.w3.org/2004/02/skos/core#example' => array('singular' => 'example', 'plural' => 'examples', 'inverse' => 'is example of'),
                      'http://www.w3.org/2004/02/skos/core#historyNote' => array('singular' => 'history note', 'plural' => 'history notes', 'inverse' => 'is history note of'),
                      'http://www.w3.org/2004/02/skos/core#editorialNote' => array('singular' => 'editorial note', 'plural' => 'editorial notes', 'inverse' => 'is editorial note of'),
                      'http://www.w3.org/2004/02/skos/core#changeNote' => array('singular' => 'change note', 'plural' => 'change notes', 'inverse' => 'is change note of'),
                      'http://www.w3.org/2004/02/skos/core#inScheme' => array('singular' => 'scheme', 'plural' => 'schemes', 'inverse' => 'is scheme of'),
                      'http://www.w3.org/2004/02/skos/core#hasTopConcept' => array('singular' => 'top concept', 'plural' => 'top concepts', 'inverse' => 'is top concept of'),
                      'http://www.w3.org/2004/02/skos/core#exactMatch' => array('singular' => 'exact match', 'plural' => 'exact matches', 'inverse' => 'is exact match of'),
                      'http://www.w3.org/2004/02/skos/core#closeMatch' => array('singular' => 'close match', 'plural' => 'close matches', 'inverse' => 'is close match of'),
                      'http://www.w3.org/2004/02/skos/core#broadMatch' => array('singular' => 'broad match', 'plural' => 'broad matches', 'inverse' => 'is broad match of'),
                      'http://www.w3.org/2004/02/skos/core#narrowMatch' => array('singular' => 'narrow match', 'plural' => 'narrow matches', 'inverse' => 'is narrow match of'),
                      'http://www.w3.org/2004/02/skos/core#relatedMatch' => array('singular' => 'related match', 'plural' => 'related matches', 'inverse' => 'is related match of'),
                      'http://rdfs.org/ns/void#exampleResource' => array('singular' => 'example resource', 'plural' => 'example resources', 'inverse' => 'is example resource of'),
                      'http://rdfs.org/ns/void#sparqlEndpoint' => array('singular' => 'SPARQL endpoint', 'plural' => 'SPARQL endpoints', 'inverse' => 'is SPARQL endpoint of'),
                      'http://rdfs.org/ns/void#subset' => array('singular' => 'subset', 'plural' => 'subsets', 'inverse' => 'is subset of'),
                      'http://rdfs.org/ns/void#uriLookupEndpoint' => array('singular' => 'URI lookup point', 'plural' => 'URI lookup points', 'inverse' => 'is URI lookup point of'),
                      'http://rdfs.org/ns/void#dataDump' => array('singular' => 'data dump', 'plural' => 'data dumps', 'inverse' => 'is data dump of'),
                      'http://rdfs.org/ns/void#vocabulary' => array('singular' => 'vocabulary used', 'plural' => 'vocabularies used', 'inverse' => 'is vocabulary used in'),
                      'http://open.vocab.org/terms/numberOfPages' => array('singular' => 'number of pages', 'plural' => 'numbers of pages', 'inverse' => 'is number of pages of'),
                      'http://open.vocab.org/terms/subtitle' => array('singular' => 'sub-title', 'plural' => 'sub-titles', 'inverse' => 'is sub-title of'),
                      'http://purl.org/ontology/bibo/issn' => array('singular' => 'ISSN', 'plural' => 'ISSNs', 'inverse' => 'is ISSN of'),
                      'http://purl.org/ontology/bibo/eissn' => array('singular' => 'EISSN', 'plural' => 'EISSNs', 'inverse' => 'is EISSN of'),
                      'http://purl.org/ontology/bibo/isbn' => array('singular' => 'ISBN', 'plural' => 'ISBNs', 'inverse' => 'is ISBN of'),
                      'http://purl.org/ontology/bibo/lccn' => array('singular' => 'LCCN', 'plural' => 'LCCNs', 'inverse' => 'is LCCN of'),
                      'http://purl.org/ontology/bibo/contributorList' => array('singular' => 'list of contributors', 'plural' => 'lists of contributors', 'inverse' => 'is list of contributors to'),
                      'http://purl.org/ontology/bibo/authorList' => array('singular' => 'list of authors', 'plural' => 'lists of authors', 'inverse' => 'is list of authors of'),


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
            if ( array_key_exists('plural',$this->_labels[$p]) &&  ! $desc->subject_has_property($p, 'http://purl.org/net/vocab/2004/03/label#plural') ) {
              $desc->add_literal_triple($p, 'http://purl.org/net/vocab/2004/03/label#plural', $this->_labels[$p]['plural']);
            }
            if ( array_key_exists('inverse',$this->_labels[$p]) && ! $desc->subject_has_property($p, 'http://purl.org/net/vocab/2004/03/label#inverseSingular') ) {
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
