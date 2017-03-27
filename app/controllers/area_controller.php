<?php

  class AreaController extends BaseController{

    public static function index(){
      $areas = Area::all();

      View::make('area/index.html', array('areas' => $areas));

    }
  }
