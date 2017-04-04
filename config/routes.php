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

  $routes->get('/area/new', function() {
    AreaController::newArea();
  });

  $routes->get('/area/:id', function($id) {
    AreaController::show($id);
  });

  $routes->post('/area', function(){
    AreaController::store();
  });

  // $routes->get('/areatopics', function() {
  //   HelloWorldController::areatopics();
  // });
  //
  // $routes->get('/topic', function() {
  //   HelloWorldController::topic();
  // });

  $routes->get('/search', function() {
    HelloWorldController::search();
  });

  $routes->get('/message/new', function() {
    MessageController::newMessage();
  });

  $routes->post('/message', function(){
    MessageController::store();
  });

  $routes->get('/topic/new', function() {
    TopicController::newTopic();
  });

  $routes->get('/topic/:id', function($id){
    TopicController::show($id);
  });

  $routes->post('/topic/:id/edit', function($id){
    TopicController::edit($id);
  });

  $routes->post('/topic', function(){
    TopicController::store();
  });

  $routes->post('/topic/:id', function($id){
    TopicController::update($id);
  });
