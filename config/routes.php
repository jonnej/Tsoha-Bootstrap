<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/login', function() {
    HelloWorldController::login();
  });

  $routes->get('/register', function() {
    HelloWorldController::register();
  });

  $routes->get('/discussionareas', function() {
    HelloWorldController::discussionareas();
  });

  $routes->get('/areatopics', function() {
    HelloWorldController::areatopics();
  });

  $routes->get('/topic', function() {
    HelloWorldController::topic();
  });
