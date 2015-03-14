Paget is [Opinionated Software](http://gettingreal.37signals.com/ch04_Make_Opinionated_Software.php). It has its own view of how resource-centric, data-driven web applications should be developed. If you don't share that opinion then you're going to find using Paget tough going. If you happen to agree then Paget should smooth your way to building great applications.

**Paget is resource-centric**. You define your application in terms of the resources it exposes to the Web. Resources are identified solely by their URI. This takes some getting used to for many web developers.

**Paget is data-driven**, specifically RDF data. Paget is designed around RDF data and relies on it to represent the state of the application's resources.

Because all data is represented as RDF internally, Paget can automatically represent that data in various formats such as XML, JSON, Turtle and HTML. Content negotiation for those data types is built in and Paget provides hooks for you to customise the HTML output which is where you ought to be applying your creative energy.

Paget also has opinions about how your URIs should be constructed in your application. URIs without a file extension are assumed to be "abstract resources". Those with a file extension are assumed to be descriptions of abstract resources. Paget will issue a "303 see also" redirect from the abstract resource to its description, performing content negotiation to send the client to the most appropriate format:

```
  http://example.com/things/resource  ---,
                                         |
 ,--------- 303 Redirect ----------------'
 |
 |
 |----> http://example.com/things/resource.html
 |----> http://example.com/things/resource.rdf
 |----> http://example.com/things/resource.json
 \----> http://example.com/things/resource.turtle

```

That means every separate representation format has its own URI derived from the base URI of the abstract resource. If you're using a URI like `http://example.com/people/jack` to represent a person then `http://example.com/people/jack.html` will be the URI of the HTML page about him. `http://example.com/people/jack.rdf` will be the URI of the RDF version of the data about him. Paget will automatically add triples to the description's data that link the description to its abstract resource and to other representations of the data.

You might want to read GettingStarted next