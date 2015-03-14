You can use a local file to store the RDF that you want Paget to make browseable.

See GettingStarted first for basic information about how Paget expects you to lay out your files. Put the following in index.php:

```
class FileBasedUriSpace extends PAGET_UriSpace {
  function get_description($uri) {
    return new FileBasedResourceDescription($uri, 'myfile.rdf', 'rdfxml'); 
  } 
}

class FileBasedResourceDescription extends PAGET_ResourceDescription {
  var $_filename;
  var $_format;

  function __construct($uri, $filename, $format) {
    $this->_filename = $filename;
    $this->_format = $format;
    parent::__construct($uri);  
  }

  function get_generators() {
    return array( new PAGET_FileGenerator($this->_filename, $this->_format) );
  }

}

$space = new FileBasedUriSpace();
$space->dispatch();
```

If you have different files containing RDF for different URIs then you could modify the get\_description method in FileBasedUriSpace to switch the filename depending on the URI being requested.