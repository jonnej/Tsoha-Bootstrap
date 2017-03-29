<?php

  class MessageController extends BaseController{

    public static function newMessage(){

      View::make('message/new.html');
    }

    public static function store(){

      $params = $_POST;
      $message = new Message(array(
        'player_id' => $params['player_id'],
        'topic_id' => $params['topic_id'],
        'msgtext' => $params['msgtext'],
      ));

      $message->save();
      Redirect::to('/topic/' . $message->topic_id, array('message' => 'Viesti lähetetty!'));
    }
  }
