<?php

  class MessageController extends BaseController{

    public static function new(){

      View::make('message/new.html');
    }
  }
