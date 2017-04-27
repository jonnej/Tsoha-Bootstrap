<?php

  class MessageController extends BaseController{

    public static function newMessage(){
      self::player_logged_in();
      $session = $_SESSION;
      View::make('message/new.html', array('session' => $session));
    }

    public static function edit($id){
      self::player_logged_in();
      $session = $_SESSION;
      $message = Message::findById($id);
      $topic = Topic::find($message->topic_id);
      View::make('message/edit.html', array('session' => $session, 'message' => $message, 'topic' => $topic));
    }

    public static function store(){
      $params = $_POST;
      $attributes = array(
        'player_id' => $params['player_id'],
        'topic_id' => $params['topic_id'],
        'msgtext' => $params['msgtext'],
      );

      $message = new Message($attributes);
      $errors = $message->errors();

      if(count($errors) == 0){
        $message->save();
        Redirect::to('/topic/' . $message->topic_id, array('message' => 'Viesti lähetetty!'));
      }else{
        $session = $_SESSION;
        View::make('message/new.html', array('errors' => $errors, 'attributes' => $attributes, 'session' => $session));
      }

    }

    public static function update($id){
      $params = $_POST;
      $attributes = array(
        'id' => $params['message_id'],
        'player_id' => $params['player_id'],
        'topic_id' => $params['topic_id'],
        'msgtext' => $params['msgtext'],
      );

      $message = new Message($attributes);
      $errors = $message->errors();

      if(count($errors) == 0){
        $message->update($id, $attributes);
        Redirect::to('/topic/' . $message->topic_id, array('message' => 'Viestiä muokattiin!'));
      }else{
        $session = $_SESSION;
        View::make('message/edit.html', array('errors' => $errors, 'message' => $message, 'session' => $session));
      }

    }

    public static function destroy($id){
      $message = new Message(array('id' => $id));
      $message->destroy($id);

      Redirect::to('/topic/' . $_SESSION['topic_id'], array('message' => 'Viesti poistettiin onnistuneesti'));
    }
  }
