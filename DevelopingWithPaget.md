The PAGET\_UriSpace class is the main dispatch point for a Paget application. Typically you will derive a new class from it and then call its dispatch method.

```
$space = new CustomUriSpace();
$space->dispatch();
```

Resources are split into three categories: documents that can be served straight up, abstract resources and descriptions of abstract resources. The last two are where the interesting bits of Paget lie.

Usually you can accomplish all you need by overriding PAGET\_UriSpace's get\_description method to return a custom description derived from PAGET\_ResourceDescription. You can select different resource descriptions by switching on the URI that is passed into that method.

This PAGET\_ResourceDescription does all the hard work of finding triples about the requested abstract resource. You can override several methods to customise the RDF returned:

## get\_resources ##
This method returns an array of resource URIs that the description will consider when generating its RDF. The default behaviour is simply to chop the file extension off of the description’s URI. So, the description at http://iandavis.com/id/me.rdf will have a resource of http://iandavis.com/id/me.

## get\_generators ##
This returns a list of generators that seed the triples in the descrpition. The ResourceDescription class calls each generator’s add\_triples method once for each resource returned by the get\_resources method. Paget has some pre-defined generators that can read triples from a local file or from a platform store. The default behaviour is to do nothing.

## get\_augmentors ##
This returns a list of augmentors that add triples to the description. Paget comes with a few built-in augmentors to augment with RDF from a platform store, annotate properties with human readable labels and even do some limited inferencing. By default the simple property labeller is returned as an augmentor.

## get\_label ##
This just calculates a sensible label for the description that could be used in the title of a web page or a link. The default behaviour is to look for an rdfs:label, dc:title or foaf:name for the primary resource in the description (which is the first one returned by get\_resources). Applications could override this to use whatever heuristics make sense for their data.

## get ##
This is the dispatch point for HTTP GET requests. At a later date I hope to handle other methods too, but for now Paget is a read only system