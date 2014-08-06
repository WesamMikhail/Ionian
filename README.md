PHP-Framework - (PHP 5.4+)
=============

This is a pretty simple little framework that works as a resource router.
It takes a request and parse out the requested resource as well as the given parameters.
The parsed strings are translated into Controller --> Action and the results of the action are dumped on the screen.

Example:

The following request: www.domain.com/test/param1

with the routing rule in router.php: $request->route("/test/:testparam","test@index");

translates to: TestController.php --> indexAction() with the array(testparam => param1) passed in.

indexAction() can dump API data in JSON/XML format or use a view template to render a full page.
