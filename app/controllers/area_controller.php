<?php

  class AreaController extends BaseController{

    public static function index(){
      self::player_logged_in();
      $areas = Area::all();
      View::make('area/index.html', array('areas' => $areas));

    }

    public static function show($id){
      self::player_logged_in();
      $_SESSION['area_id'] = $id;
      $area = Area::find($id);
      $topics = Topic::findByArea($id);
      View::make('area/show.html', array('topics' => $topics, 'area' => $area));
    }

    public static function newArea(){
      self::player_logged_in();
      View::make('area/new.html', array());
    }

    public static function store(){

      $params = $_POST;
      $attributes = array(
        'player_id' => $params['player_id'],
        'name' => $params['name'],
        'description' => $params['description']

      );

      $area = new Area($attributes);
      $errors = $area->errors();

      if(count($errors) == 0){
        $area->save();
        $_SESSION['area_id'] = $area->id;
        Redirect::to('/area/' . $area->id, array('message' => 'Uusi keskustelualue luotiin onnistuneesti!'));
      }else{
        View::make('area/new.html', array('errors' => $errors, 'attributes' => $attributes));
      }


    }

    public static function destroy($id){
      $area = new Area(array('id' => $id));
      $area->destroy($id);

      Redirect::to('/area', array('message' => 'Keskustelualue ja sen sisältö poistettiin onnistuneesti'));

    }
  }
