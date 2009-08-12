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
                      'http://xmlns.com/foaf/0.1/isPrimaryTopicOf' => array('singular' => 'primary topic of', 'plural' => 'primary topic of', 'inverse' => 'primary topic'),
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
                      'http://purl.org/dc/terms/modified' => array('singular' => 'date modified', 'plural' => 'dates modified', 'inverse' => 'is date modified of'),
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
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#type','type','types','is type of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_1','first', 'first', 'is first member of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_2','second', 'second', 'is second member of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_3','third', 'third', 'is third member of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_4','fourth', 'fourth', 'is fourth member of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_5','fifth', 'fifth', 'is fifth member of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_6','sixth', 'sixth', 'is sixth member of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_7','seventh', 'seventh', 'is seventh member of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_8','eighth', 'eighth', 'is eighth member of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_9','ninth', 'ninth', 'is ninth member of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_10','tenth', 'tenth', 'is tenth member of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_11','eleventh', 'eleventh', 'is eleventh member of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_12','twelth', 'twelth', 'is twelth member of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_13','thirteenth', 'thirteenth', 'is thirteenth member of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_14','fourteenth', 'fourteenth', 'is fourteenth member of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_15','fifteenth', 'fifteenth', 'is fifteenth member of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_16','sixteenth', 'sixteenth', 'is sixteenth member of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_17','seventeenth', 'seventeenth', 'is seventeenth member of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_18','eighteenth', 'eighteenth', 'is eighteenth member of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_19','nineteenth', 'nineteenth', 'is nineteenth member of');
    $this->add_label('http://www.w3.org/1999/02/22-rdf-syntax-ns#_20','twentieth', 'twentieth', 'is twentieth member of');

    $this->add_label('http://www.w3.org/2000/01/rdf-schema#label','label','labels','is label of');
    $this->add_label('http://www.w3.org/2000/01/rdf-schema#comment','comment','comments','is comment of');
    $this->add_label('http://www.w3.org/2000/01/rdf-schema#seeAlso','see also','see also','is see also of');
    $this->add_label('http://www.w3.org/2000/01/rdf-schema#isDefinedBy','defined by','defined by','defines');
    $this->add_label('http://www.w3.org/2000/01/rdf-schema#range','range','ranges','is range of');
    $this->add_label('http://www.w3.org/2000/01/rdf-schema#domain','domain','domains','is domain of');
    $this->add_label('http://www.w3.org/2000/01/rdf-schema#subClassOf','subclass of','subclass of','is superclass of');

    $this->add_label('http://www.w3.org/2002/07/owl#imports','imports','imports','is imported by');
    $this->add_label('http://www.w3.org/2002/07/owl#sameAs','same as','same as','same as');

    $this->add_label('http://xmlns.com/foaf/0.1/isPrimaryTopicOf','is primary topic of','is primary topic of','primary topic');
    $this->add_label('http://xmlns.com/foaf/0.1/primaryTopic','primary topic','primary topics','is the primary topic of');
    $this->add_label('http://xmlns.com/foaf/0.1/topic','topic','topics','is a topic of');
    $this->add_label('http://xmlns.com/foaf/0.1/name','name','names','is name of');
    $this->add_label('http://xmlns.com/foaf/0.1/homepage','homepage','homepages','is homepage of');
    $this->add_label('http://xmlns.com/foaf/0.1/page','webpage','webpages','is webpage of');
    $this->add_label('http://xmlns.com/foaf/0.1/weblog','blog','blogs','is weblog of');
    $this->add_label('http://xmlns.com/foaf/0.1/knows','knows','knows','knows');
    $this->add_label('http://xmlns.com/foaf/0.1/interest','interest','interests','is interest of');
    $this->add_label('http://xmlns.com/foaf/0.1/firstName','first name','first names','is first name of');
    $this->add_label('http://xmlns.com/foaf/0.1/surname','surname','surnames','is surname of');
    $this->add_label('http://xmlns.com/foaf/0.1/depiction','picture','pictures','is picture of');
    $this->add_label('http://xmlns.com/foaf/0.1/nick','nickname','nickname','is nickname of');
    $this->add_label('http://xmlns.com/foaf/0.1/phone','phone number' );
    $this->add_label('http://xmlns.com/foaf/0.1/mbox','email address' );
    $this->add_label('http://xmlns.com/foaf/0.1/workplaceHomepage','workplace\'s homepage' );
    $this->add_label('http://xmlns.com/foaf/0.1/schoolHomepage','school\'s homepage' );
    $this->add_label('http://xmlns.com/foaf/0.1/openid','OpenID' );
    $this->add_label('http://xmlns.com/foaf/0.1/mbox_sha1sum','email address hashcode' );
    $this->add_label('http://xmlns.com/foaf/0.1/title','title' );
    $this->add_label('http://xmlns.com/foaf/0.1/maker','maker', 'makers', 'made' );
    $this->add_label('http://xmlns.com/foaf/0.1/made','made', 'made', 'maker' );
    $this->add_label('http://xmlns.com/foaf/0.1/accountProfilePage','account profile page');
    $this->add_label('http://xmlns.com/foaf/0.1/accountName','account name');
    $this->add_label('http://xmlns.com/foaf/0.1/accountServiceHomepage','account service homepage');
    $this->add_label('http://xmlns.com/foaf/0.1/holdsAccount','account', 'accounts', 'is account held by');

    $this->add_label('http://rdfs.org/sioc/ns#topic','topic');

    $this->add_label('http://purl.org/dc/elements/1.1/title','title','titles','is the title of');
    $this->add_label('http://purl.org/dc/elements/1.1/description','description','descriptions','is description of');
    $this->add_label('http://purl.org/dc/elements/1.1/date','date','dates','is date of');
    $this->add_label('http://purl.org/dc/elements/1.1/identifier','identifier','identifiers','is identifier of');
    $this->add_label('http://purl.org/dc/elements/1.1/type','document type','document types','is document type of');
    $this->add_label('http://purl.org/dc/elements/1.1/contributor','contributor','contributors','is contributor to');
    $this->add_label('http://purl.org/dc/elements/1.1/rights','rights statement','right statements','is rights statement for');
    $this->add_label('http://purl.org/dc/elements/1.1/subject','subject','subjects','is subject for');
    $this->add_label('http://purl.org/dc/elements/1.1/publisher','publisher','publishers','is publisher of');
    $this->add_label('http://purl.org/dc/elements/1.1/creator','creator','creators','is creator of');

    $this->add_label('http://purl.org/dc/terms/abstract','abstract','abstracts','is abstract of');
    $this->add_label('http://purl.org/dc/terms/accessRights','access rights','access rights','are access rights for');
    $this->add_label('http://purl.org/dc/terms/alternative','alternative title','alternative titles','is alternative title for');
    $this->add_label('http://purl.org/dc/terms/audience','audience','audiences','is audience for');
    $this->add_label('http://purl.org/dc/terms/available','date available','dates available','is date available of');
    $this->add_label('http://purl.org/dc/terms/bibliographicCitation','bibliographic citation','bibliographic citations','is bibliographic citation of');
    $this->add_label('http://purl.org/dc/terms/contributor','contributor','contributors','is contributor to');
    $this->add_label('http://purl.org/dc/terms/coverage','coverage','coverage','is coverage of');
    $this->add_label('http://purl.org/dc/terms/created','date created','dates created','is date created of');
    $this->add_label('http://purl.org/dc/terms/creator','creator','creators','is creator of');
    $this->add_label('http://purl.org/dc/terms/date','date','dates','is date of');
    $this->add_label('http://purl.org/dc/terms/dateAccepted','date accepted','dates accepted','is date accepted of');
    $this->add_label('http://purl.org/dc/terms/dateCopyrighted','date copyrighted','dates copyrighted','is date copyrighted of');
    $this->add_label('http://purl.org/dc/terms/dateSubmitted','date submitted','dates submitted','is date submitted of');
    $this->add_label('http://purl.org/dc/terms/description','description','descriptions','is description of');
    $this->add_label('http://purl.org/dc/terms/format','format','formats','is format of');
    $this->add_label('http://purl.org/dc/terms/hasPart','has part','has parts','is part of');
    $this->add_label('http://purl.org/dc/terms/hasVersion','version','versions','version of');
    $this->add_label('http://purl.org/dc/terms/identifier','identifier','identifiers','is identifier of');
    $this->add_label('http://purl.org/dc/terms/isPartOf','part of','part of','part');
    $this->add_label('http://purl.org/dc/terms/isReferencedBy','is referenced by','is referenced by','references');
    $this->add_label('http://purl.org/dc/terms/isReplacedBy','is replaced by','is replaced by','replaces');
    $this->add_label('http://purl.org/dc/terms/isRequiredBy','is required by','is required by','requires');
    $this->add_label('http://purl.org/dc/terms/issued','date issued','dates issued','is date issued of');
    $this->add_label('http://purl.org/dc/terms/isVersionOf','version of','version of','version');
    $this->add_label('http://purl.org/dc/terms/language','language','languages','is language of');
    $this->add_label('http://purl.org/dc/terms/license','license','licenses','is license of');
    $this->add_label('http://purl.org/dc/terms/medium','medium','media','is medium of');
    $this->add_label('http://purl.org/dc/terms/modified','date modified','dates modified','is date modified of');
    $this->add_label('http://purl.org/dc/terms/provenance','provenance','provenances','is provenance of');
    $this->add_label('http://purl.org/dc/terms/publisher','publisher','publishers','is publisher of');
    $this->add_label('http://purl.org/dc/terms/replaces','replaces','replaces','replaced by');
    $this->add_label('http://purl.org/dc/terms/references','references','references','is referenced by');
    $this->add_label('http://purl.org/dc/terms/relation','relation','relations','relation');
    $this->add_label('http://purl.org/dc/terms/replaces','replaces','replaces','is replaced by');
    $this->add_label('http://purl.org/dc/terms/requires','requires','requires','is required by');
    $this->add_label('http://purl.org/dc/terms/rights','rights statement','right statements','is rights statement for');
    $this->add_label('http://purl.org/dc/terms/rightsHolder','rights holder','rights holders','is rights holder of');
    $this->add_label('http://purl.org/dc/terms/source','source','sources','is source of');
    $this->add_label('http://purl.org/dc/terms/subject','subject','subjects','is subject of');
    $this->add_label('http://purl.org/dc/terms/tableOfContents','table of contents','tables of contents','is table of contents of');
    $this->add_label('http://purl.org/dc/terms/title','title','titles','is the title of');
    $this->add_label('http://purl.org/dc/terms/type','document type','document types','is document type of');
    $this->add_label('http://purl.org/dc/terms/updated','date updated','dates updated','is date updated of');
    $this->add_label('http://purl.org/dc/terms/valid','date valid','dates valid','is date valid of');

    $this->add_label('http://www.w3.org/2003/01/geo/wgs84_pos#lat','latitude','latitudes','is latitude of');
    $this->add_label('http://www.w3.org/2003/01/geo/wgs84_pos#long','longitude','longitudes','is longitude of');
    $this->add_label('http://www.w3.org/2003/01/geo/wgs84_pos#location','location');

    $this->add_label('http://purl.org/vocab/bio/0.1/olb','one line bio','one line bios','is one line bio of');
    $this->add_label('http://purl.org/vocab/bio/0.1/event','life event','life events','is life event of');
    $this->add_label('http://purl.org/vocab/bio/0.1/date','date');

    $this->add_label('http://purl.org/vocab/relationship/parentOf','is parent of','is parent of','is child of');
    $this->add_label('http://purl.org/vocab/relationship/childOf','is child of','is child of','is parent of');
    $this->add_label('http://purl.org/vocab/relationship/spouseOf','spouse','spouses','spouse');
    $this->add_label('http://purl.org/vocab/relationship/acquaintanceOf','acquaintance');
    $this->add_label('http://purl.org/vocab/relationship/friendOf','friend');

    $this->add_label('http://purl.org/vocab/vann/example','example','examples','is example for');
    $this->add_label('http://purl.org/vocab/vann/preferredNamespacePrefix','preferred namespace prefix','preferred namespace prefixes','is preferred namespace prefix for');
    $this->add_label('http://purl.org/vocab/vann/preferredNamespaceUri','preferred namespace URI','preferred namespace URIs','is preferred namespace URI for');
    $this->add_label('http://purl.org/vocab/vann/changes','change log','change logs','is change log of');

    $this->add_label('http://www.w3.org/2004/02/skos/core#prefLabel','preferred label','preferred labels','is preferred label of');
    $this->add_label('http://www.w3.org/2004/02/skos/core#altLabel','alternative label','alternative labels','is alternative label of');
    $this->add_label('http://www.w3.org/2004/02/skos/core#hiddenLabel','hidden label','hidden labels','is hidden label of');
    $this->add_label('http://www.w3.org/2004/02/skos/core#member','member','members','is a member of');
    $this->add_label('http://www.w3.org/2004/02/skos/core#related','related concept','related concepts','is related concept of');
    $this->add_label('http://www.w3.org/2004/02/skos/core#definition','definition','definitions','is definition of');
    $this->add_label('http://www.w3.org/2004/02/skos/core#context','context','contexts','is context of');
    $this->add_label('http://www.w3.org/2004/02/skos/core#broader','broader concept','broader concepts','narrower concept');
    $this->add_label('http://www.w3.org/2004/02/skos/core#narrower','narrower concept','narrower concepts','broader concept');
    $this->add_label('http://www.w3.org/2004/02/skos/core#note','note','notes','is note of');
    $this->add_label('http://www.w3.org/2004/02/skos/core#scopeNote','scope note','scope notes','is scope note of');
    $this->add_label('http://www.w3.org/2004/02/skos/core#example','example','examples','is example of');
    $this->add_label('http://www.w3.org/2004/02/skos/core#historyNote','history note','history notes','is history note of');
    $this->add_label('http://www.w3.org/2004/02/skos/core#editorialNote','editorial note','editorial notes','is editorial note of');
    $this->add_label('http://www.w3.org/2004/02/skos/core#changeNote','change note','change notes','is change note of');
    $this->add_label('http://www.w3.org/2004/02/skos/core#inScheme','scheme','schemes','is scheme of');
    $this->add_label('http://www.w3.org/2004/02/skos/core#hasTopConcept','top concept','top concepts','is top concept of');
    $this->add_label('http://www.w3.org/2004/02/skos/core#topConceptOf','is top concept of','are top concepts of','top concept');
    $this->add_label('http://www.w3.org/2004/02/skos/core#exactMatch','exact match','exact matches','is exact match of');
    $this->add_label('http://www.w3.org/2004/02/skos/core#closeMatch','close match','close matches','is close match of');
    $this->add_label('http://www.w3.org/2004/02/skos/core#broadMatch','broad match','broad matches','is broad match of');
    $this->add_label('http://www.w3.org/2004/02/skos/core#narrowMatch','narrow match','narrow matches','is narrow match of');
    $this->add_label('http://www.w3.org/2004/02/skos/core#relatedMatch','related match','related matches','is related match of');

    $this->add_label('http://rdfs.org/ns/void#exampleResource','example resource','example resources','is example resource of');
    $this->add_label('http://rdfs.org/ns/void#sparqlEndpoint','SPARQL endpoint','SPARQL endpoints','is SPARQL endpoint of');
    $this->add_label('http://rdfs.org/ns/void#subset','subset','subsets','is subset of');
    $this->add_label('http://rdfs.org/ns/void#uriLookupEndpoint','URI lookup point','URI lookup points','is URI lookup point of');
    $this->add_label('http://rdfs.org/ns/void#dataDump','data dump','data dumps','is data dump of');
    $this->add_label('http://rdfs.org/ns/void#vocabulary','vocabulary used','vocabularies used','is vocabulary used in');
    $this->add_label('http://rdfs.org/ns/void#uriRegexPattern', 'URI regex pattern');

    $this->add_label('http://open.vocab.org/terms/numberOfPages','number of pages','numbers of pages','is number of pages of');
    $this->add_label('http://open.vocab.org/terms/subtitle','sub-title','sub-titles','is sub-title of');
    $this->add_label('http://open.vocab.org/terms/firstSentence', 'first sentence');
    $this->add_label('http://open.vocab.org/terms/weight', 'weight');
    $this->add_label('http://open.vocab.org/terms/isCategoryOf', 'is category of', 'is category of', 'category');
    $this->add_label('http://open.vocab.org/terms/category', 'category', 'categories', 'is category of');

    $this->add_label('http://purl.org/ontology/bibo/edition','edition');
    $this->add_label('http://purl.org/ontology/bibo/issue','issue');
    $this->add_label('http://purl.org/ontology/bibo/volume','volume');
    $this->add_label('http://purl.org/ontology/bibo/pageStart','first page');
    $this->add_label('http://purl.org/ontology/bibo/pageEnd','last page');
    $this->add_label('http://purl.org/ontology/bibo/issn','ISSN','ISSNs','is ISSN of');
    $this->add_label('http://purl.org/ontology/bibo/eissn','EISSN','EISSNs','is EISSN of');
    $this->add_label('http://purl.org/ontology/bibo/isbn','ISBN','ISBNs','is ISBN of');
    $this->add_label('http://purl.org/ontology/bibo/isbn10','10 digit ISBN','10 digit ISBNs','is 10 digit ISBN of');
    $this->add_label('http://purl.org/ontology/bibo/isbn13','13 digit ISBN','13 digit ISBNs','is 13 digit ISBN of');
    $this->add_label('http://purl.org/ontology/bibo/lccn','LCCN','LCCNs','is LCCN of');
    $this->add_label('http://purl.org/ontology/bibo/doi','DOI','DOIs','is DOI of');
    $this->add_label('http://purl.org/ontology/bibo/oclcnum','OCLC number','OCLC numbers','is OCLC number of');
    $this->add_label('http://purl.org/ontology/bibo/contributorList','list of contributors','lists of contributors','is list of contributors to');
    $this->add_label('http://purl.org/ontology/bibo/authorList','list of authors','lists of authors','is list of authors of');


    $this->add_label('http://purl.org/ontology/mo/wikipedia','wikipedia page','wikipedia pages','is wikipedia page of');

    $this->add_label('http://purl.org/ontology/po/episode','episode');
    $this->add_label('http://purl.org/ontology/po/series','series','series');
    $this->add_label('http://purl.org/ontology/po/medium_synopsis','medium synopsis','medium synopses');
    $this->add_label('http://purl.org/ontology/po/short_synopsis','short synopsis','short synopses');
    $this->add_label('http://purl.org/ontology/po/long_synopsis','long synopsis','long synopses');
    $this->add_label('http://purl.org/ontology/po/genre','genre');
    $this->add_label('http://purl.org/ontology/po/microsite','microsite');
    $this->add_label('http://purl.org/ontology/po/format','programme format');
    $this->add_label('http://purl.org/ontology/po/masterbrand','master  brand');

    $this->add_label('http://purl.org/net/schemas/space/actor','actor','actors','performed');
    $this->add_label('http://purl.org/net/schemas/space/performed','performed','performed','actor');
    $this->add_label('http://purl.org/net/schemas/space/role', 'role');
    $this->add_label('http://purl.org/net/schemas/space/mission', 'mission');
    $this->add_label('http://purl.org/net/schemas/space/missionRole', 'mission role');
    $this->add_label('http://purl.org/net/schemas/space/alternateName', 'alternate name');
    $this->add_label('http://purl.org/net/schemas/space/mass', 'mass');
    $this->add_label('http://purl.org/net/schemas/space/discipline', 'discipline');
    $this->add_label('http://purl.org/net/schemas/space/spacecraft', 'spacecraft', 'spacecraft');
    $this->add_label('http://purl.org/net/schemas/space/agency', 'agency');
    $this->add_label('http://purl.org/net/schemas/space/launch', 'launch', 'launches');
    $this->add_label('http://purl.org/net/schemas/space/launchvehicle', 'launch vehicle');
    $this->add_label('http://purl.org/net/schemas/space/launchsite', 'launch site');
    $this->add_label('http://purl.org/net/schemas/space/launched', 'launched', 'launched');
    $this->add_label('http://purl.org/net/schemas/space/country', 'country', 'countries');
    $this->add_label('http://purl.org/net/schemas/space/place', 'place');

    $this->add_label('http://www.ordnancesurvey.co.uk/ontology/AdministrativeGeography/v2.0/AdministrativeGeography.rdf#borders', 'borders', 'borders', 'borders');
    $this->add_label('http://www.ordnancesurvey.co.uk/ontology/AdministrativeGeography/v2.0/AdministrativeGeography.rdf#hasCensusCode', 'census code');
    $this->add_label('http://www.ordnancesurvey.co.uk/ontology/AdministrativeGeography/v2.0/AdministrativeGeography.rdf#hasArea', 'area');
    $this->add_label('http://www.ordnancesurvey.co.uk/ontology/AdministrativeGeography/v2.0/AdministrativeGeography.rdf#hasName', 'name');
    $this->add_label('http://www.ordnancesurvey.co.uk/ontology/AdministrativeGeography/v2.0/AdministrativeGeography.rdf#hasOfficialName', 'official name');
    $this->add_label('http://www.ordnancesurvey.co.uk/ontology/AdministrativeGeography/v2.0/AdministrativeGeography.rdf#hasOfficialWelshName', 'official welsh name');
    $this->add_label('http://www.ordnancesurvey.co.uk/ontology/AdministrativeGeography/v2.0/AdministrativeGeography.rdf#hasVernacularName', 'vernacular name');
    $this->add_label('http://www.ordnancesurvey.co.uk/ontology/AdministrativeGeography/v2.0/AdministrativeGeography.rdf#hasBoundaryLineName', 'boundary line name');
    $this->add_label('http://www.ordnancesurvey.co.uk/ontology/AdministrativeGeography/v2.0/AdministrativeGeography.rdf#completelySpatiallyContains', 'completely spatially contains',  'completely spatially contains',  'is completely spatially contained by');
    $this->add_label('http://www.ordnancesurvey.co.uk/ontology/AdministrativeGeography/v2.0/AdministrativeGeography.rdf#tangentiallySpatiallyContains', 'tangentially spatially contains',  'tangentially spatially contains',  'is tangentially spatially contained by');
    $this->add_label('http://www.ordnancesurvey.co.uk/ontology/AdministrativeGeography/v2.0/AdministrativeGeography.rdf#isSpatiallyEqualTo', 'spatially equal to',  'spatially equal to',  'spatially equal to');

    $this->add_label('http://rdvocab.info/Elements/placeOfPublication', 'place of publication',  'places of publication');

    $this->add_label('http://www.w3.org/2000/10/swap/pim/contact#nearestAirport', 'nearest airport');

    $this->add_label('http://www.daml.org/2001/10/html/airport-ont#icao', 'ICAO', 'ICAOs', 'is ICAO of');
    $this->add_label('http://www.daml.org/2001/10/html/airport-ont#iata', 'IATA', 'IATAs', 'is IATA of');

    $this->add_label('http://schemas.talis.com/2005/address/schema#regionName', 'region name');
    $this->add_label('http://schemas.talis.com/2005/address/schema#streetAddress', 'street address');
    $this->add_label('http://schemas.talis.com/2005/address/schema#localityName', 'locality name');
    $this->add_label('http://schemas.talis.com/2005/address/schema#postalCode', 'postal code');

    $this->add_label('http://schemas.talis.com/2006/recordstore/schema#tags', 'tag');
    $this->add_label('http://schemas.talis.com/2006/recordstore/schema#changeReason', 'reason for change', 'reasons for change');
    $this->add_label('http://schemas.talis.com/2006/recordstore/schema#active', 'is active?', 'is active?');
    $this->add_label('http://schemas.talis.com/2006/recordstore/schema#createdDate', 'date created', 'dates created');
    $this->add_label('http://schemas.talis.com/2006/recordstore/schema#previousState', 'previous state');
    $this->add_label('http://schemas.talis.com/2006/recordstore/schema#appliedBy', 'applied by','applied by');
    $this->add_label('http://schemas.talis.com/2006/recordstore/schema#appliedDate', 'date applied','dates applied');
    $this->add_label('http://schemas.talis.com/2006/recordstore/schema#reason', 'reason');
    $this->add_label('http://schemas.talis.com/2006/recordstore/schema#note', 'note');

    $this->add_label('http://schemas.talis.com/2005/dir/schema#etag', 'ETag');

    $this->add_label('http://www.w3.org/2006/vcard/ns#label', 'label');

    $this->add_label('http://www.gazettes-online.co.uk/ontology#hasEdition', 'edition');
    $this->add_label('http://www.gazettes-online.co.uk/ontology#hasIssueNumber', 'issue number');
    $this->add_label('http://www.gazettes-online.co.uk/ontology#hasPublicationDate', 'publication date');
    $this->add_label('http://www.gazettes-online.co.uk/ontology#hasNoticeNumber', 'notice number');
    $this->add_label('http://www.gazettes-online.co.uk/ontology#hasNoticeCode', 'notice code');
    $this->add_label('http://www.gazettes-online.co.uk/ontology#isAbout', 'about', 'about');
    $this->add_label('http://www.gazettes-online.co.uk/ontology#isInIssue', 'issue');
    $this->add_label('http://www.gazettes-online.co.uk/ontology/location#hasAddress', 'address', 'addresses');
    $this->add_label('http://www.gazettes-online.co.uk/ontology/court#courtName', 'court name');
    $this->add_label('http://www.gazettes-online.co.uk/ontology/court#sitsAt', 'sits at', 'sits at');

    $this->add_label('http://purl.org/stuff/rev#text', 'text', 'text');
    $this->add_label('http://purl.org/stuff/rev#hasReview', 'review');
    $this->add_label('http://purl.org/stuff/rev#reviewer', 'reviewer');
    $this->add_label('http://purl.org/stuff/rev#positiveVotes', 'positive votes', 'positive votes');
    $this->add_label('http://purl.org/stuff/rev#totalVotes', 'total votes', 'total votes');
    $this->add_label('http://purl.org/goodrelations/v1#hasManufacturer', 'manufacturer');
    $this->add_label('http://purl.org/goodrelations/v1#offers', 'offering', 'offerings', 'is offering of');
    $this->add_label('http://purl.org/goodrelations/v1#hasPriceSpecification', 'price specification');
    $this->add_label('http://purl.org/goodrelations/v1#includesObject', 'includes', 'includes', 'is included with');
    $this->add_label('http://purl.org/goodrelations/v1#hasBusinessFunction', 'business function');
    $this->add_label('http://purl.org/goodrelations/v1#amountOfThisGood', 'amount of good', 'amounts of good');
    $this->add_label('http://purl.org/goodrelations/v1#typeOfGood', 'type of good', 'types of good', 'is type of good for');
    $this->add_label('http://purl.org/goodrelations/v1#isSimilarTo', 'similar to', 'similar to', 'similar to');
    $this->add_label('http://purl.org/goodrelations/v1#hasEAN_UCC-13', 'EAN', 'EANs', 'is EAN of');


  

  }

  function add_label($p, $l, $pl = null, $inv = null) {
    $pl = $pl == null ? $l . 's' : $pl;
    $inv = $inv == null ? 'is ' . $l . ' of' : $inv;
    
    $this->_labels[$p] = array('singular' => $l, 'plural' => $pl, 'inverse' => $inv);
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
