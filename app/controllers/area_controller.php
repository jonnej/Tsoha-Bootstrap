<?php

  class AreaController extends BaseController{

    public static function index(){
      $areas = Area::all();
      Kint::dump($areas);
      View::make('area/index.html', array('areas' => $areas));

    }

    public static function show($id){
      $area = Area::find($id);
      $topics = Topic::findByArea($id);
      Kint::dump($area);
      Kint::dump($topics);
      View::make('area/show.html', array('topics' => $topics, 'area' => $area));
    }

    public static function newArea(){
      View::make('area/new.html');
    }

    public static function store(){

      $params = $_POST;
      $area = new Area(array(
        'player_id' => $params['player_id'],
        'name' => $params['name'],
        'description' => $params['description']

      ));

      $area->save();

      Redirect::to('/area/' . $area->id, array('message' => 'Uusi alue luotu!'));
    }
  }
