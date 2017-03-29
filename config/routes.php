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

  $routes->get('/area', function() {
    AreaController::index();
  });

  $routes->get('/area/:id', function($id) {
    AreaController::show($id);
  });

  $routes->get('/areatopics', function() {
    HelloWorldController::areatopics();
  });

  $routes->get('/topic', function() {
    HelloWorldController::topic();
  });

  $routes->get('/search', function() {
    HelloWorldController::search();
  });

  $routes->get('/topic', function() {
    HelloWorldController::topic();
  });

  $routes->get('/message/new'), function() {
    MessageController::new();
  });
