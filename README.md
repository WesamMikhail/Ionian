# Ionian - REST API Framework for PHP 5.6

Ionian is a framework that was born out of frustration with almost all current frameworks out there.

The idea here is that when you need to work on a small API with a few endpoints, a framework should not be anything more than a
router + a few classes to help make development a joy instead of a pain in the neck.


## IMPORTANT NOTICE

The only major thing that you need to know about Ionian is that it will by default ask for one of these 3 content-types headers to be supplied (and valid of course)
when working with POST or PUT requests.

application/x-www-form-urlencoded

multipart/form-data

application/json

The framework does not parse any other body data and will throw a HTTP ERROR CODE 415 if anything else is provided.


## Setup

1. Clone this repo
2. Run composer install

If you also want to install the sample project do the following:

3. Import the sample project SQL from the /Project folder into a database called **blogish**
4. See index.php for possible routes


## Application Flow

The incoming request gets redirected by the .htaccess file into **index.php** where the application starts.

The application is a router that has access to a few power functions such as setting the APP_MODE.

In index.php you start off by instanciating the router you want your project to use [see the routing part below].
You also inject the PDO DB-handler as well as the routes if your router of choice supports that.

Lastly, the run command will start the application by instanciating the controller and running the action.

Your project will live inside of the **/Project** directory and your tests will live inside **/tests/Project**.


## Routing

Ionian has multiple routers embedded that you can choose from. The current sample project uses the router called **Defined**.

- **Defined** is a RESTful router that works basically the same way all other major routers do with the only exception being no RegEx support.

- **Rapid** is an extremely fast and easy router that converts /user/add to UserController->addAction()

- **Handles** is an alias router. It is basically a RESTful router without any parameter support. It will only match EXACT routes.



## TODO

- Add framework tests
    What if null is passed as DB into model
- check how Response handles HTTPs in APP as well as ErrrorHandler
- ControllerFactory and ModelFactory should only instantiate objects of the correct interface. Currently they can instantiate anything
- update this readme
