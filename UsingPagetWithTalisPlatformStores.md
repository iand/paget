If you simply want to use a platform store to store your RDF then you can easily use Paget to provide a browseable interface.

See GettingStarted first for basic information about how Paget expects you to lay out your files. Put the following in index.php, making sure you substitute the URI of your platform store

```
class StoreBackedUriSpace extends PAGET_UriSpace {
  function get_description($uri) {
    return new StoreBackedResourceDescription($uri);
  }
}

class StoreBackedResourceDescription extends PAGET_ResourceDescription {
  function get_generators() {
    return array( new PAGET_StoreDescribeGenerator("http://api.talis.com/stores/iand") );
  }
}

$space = new StoreBackedUriSpace();
$space->dispatch();
```