# SlimApiStarter

Slim 3 starter for making JSON APIs based on the following pattern: 

- Routes map to controllers
- Controllers understand the http request and pass any data to an http agnostic action
- Actions run the application logic and set a result object
- Controller returns the result object as json