<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/register', function() {
    PlayerController::register();
  });

  $routes->post('/register', function(){
    PlayerController::store();
  });

  $routes->get('/login', function() {
    PlayerController::login();
  });

  $routes->post('/login', function(){
    PlayerController::handle_login();
  });

  $routes->get('/player/:id', function($id){
    PlayerController::show($id);
  });

  $routes->post('/logout', function() {
    PlayerController::logout();
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

  $routes->get('/search', function() {
    HelloWorldController::search();
  });

  $routes->get('/message/new', function() {
    MessageController::newMessage();
  });

  $routes->post('/message', function(){
    MessageController::store();
  });

  $routes->post('/message/:id/edit', function($id){
    MessageController::edit($id);
  });

  $routes->post('/message/:id', function($id){
    MessageController::update($id);
  });

  $routes->post('/message/:id/destroy', function($id){
    MessageController::destroy($id);
  });

  $routes->get('/topic/new', function() {
    TopicController::newTopic();
  });

  $routes->get('/topic/:id', function($id){
    if($id == null){
      AreaController::index();
    }else{
    TopicController::show($id);
  }
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

  $routes->post('/topic/:id/destroy', function($id){
    TopicController::destroy($id);
  });
