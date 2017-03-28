<?php

  class AreaController extends BaseController{

    public static function index(){
      $areas = Area::all();
      Kint::dump($areas);
      View::make('area/index.html', array('areas' => $areas));

    }

    public static function show($id){
      $area = Area::find($id);
      $topics = Area::areaTopics($id);
      Kint::dump($area);
      Kint::dump($topics);
      View::make('area/show.html', array('area' => $area), array('topics' => $topics));
    }
  }
