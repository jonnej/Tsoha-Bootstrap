<?php

  class MessageController extends BaseController{

    public static function newMessage(){

      View::make('message/new.html');
    }

    public static function store(){

      $params = $_POST;
      $topic = new Topic(array(
        'player_id' => $params['player_id'],
        'topic_id' => $params['topic_id'],
        'msgtext' => $params['msgtext'],
      ))
    }
  }
