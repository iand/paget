Every Paget application starts by deriving a class from PAGET\_UriSpace. This is the main dispatch point for requests in the application. It's responsible for identifying the resources identified by a group of URIs and the application can use it to specify the behaviour of their resources.

You need to ensure that the dispatch method of your UriSpace class is called whenever someone requests one of the URIs that you have RDF data for. The best way to do this is to put a PHP file in a common root of the URIs and then configure your web server so it routes requests for those URIs to that PHP file.

For example, if you have URIs that follow the pattern http://example.com/things/foo then you might put your PHP file in the root directory of example.com or in the things subdirectory. Your PHP file should contain something like:

```
$space = new CustomUriSpace();
$space->dispatch();
```

If you're using Apache then put the following into your .htaccess file in the same directory as your PHP file (here it's assumed to be called index.php):

```
RewriteEngine on
RewriteRule ^$  index.php [L]

RewriteCond %{REQUEST_FILENAME}  -d
RewriteRule  ^.*$  -  [L]

RewriteCond %{REQUEST_FILENAME}  -f
RewriteRule  ^.*$  -  [L]

RewriteRule ^.*$  index.php [L]

```

Those rewrite rules ensure that every request that isn't for a physical file or directory will be routed through index.php and hence through Paget. Paget will pass the requested URI to your UriSpace class which allows you to specify the behaviour needed

Once you have the basic dispatch mechanism set up for Paget you can start customising the UriSpace for your needs. What you do next depends on how your data is stored or produced:

  * [Talis Platform Store](UsingPagetWithTalisPlatformStores.md)
  * [Local RDF File](UsingPagetWithLocalRdfFiles.md)

If you're feeling more adventurous then you ought to read DevelopingWithPaget