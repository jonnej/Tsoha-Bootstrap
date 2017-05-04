<?php

  class TopicController extends BaseController{

    public static function show($id){
      self::player_logged_in();
      if($id == null) {
        Redirect::to('/area', array('message' => 'Käynti topiceihin vain klikkaamalla linkkiä!'));
      }else{
      $_SESSION['topic_id'] = $id;

      $session = $_SESSION;
      $topic = Topic::find($id);
      $messages = Message::findByTopic($id);
      View::make('topic/show.html', array('messages' => $messages, 'topic' => $topic));
      }
    }

    public static function newTopic(){
      self::player_logged_in();
      if(!isset($_SESSION['area_id'])) {
        Redirect::to('/area', array());
      }
      $areas = Area::all();
      View::make('topic/new.html', array('areas' => $areas));
    }

    public static function edit($id){
      self::player_logged_in();
      $topic = Topic::find($id);
      $first_message = Topic::firstTopicMessage($id);
      View::make('topic/edit.html', array('topic' => $topic, 'first_message' => $first_message));
    }

    public static function store(){
      $params = $_POST;

      $attributes = array(
        'area_id' => $params['area_id'],
        'player_id' => $params['player_id'],
        'name' => $params['name'],
      );

      $topic = new Topic($attributes);
      $errors = $topic->errors();

      if(strlen($params['msgtext']) < 1 || strlen($params['msgtext']) > 1000){
        $errors[] = 'Viestin pituus pitää olla vähintään 1 ja enintään 1000 merkkiä';
      }

      if(count($errors) == 0){
        $topic->save();
        $message = new Message(array(
          'player_id' => $params['player_id'],
          'topic_id' => $topic->id,
          'msgtext' => $params['msgtext'],
        ));
        $message->save();
        $_SESSION['topic_id'] = $topic->id;
        Redirect::to('/topic/' . $topic->id, array('message' => 'Uusi topic luotu!'));

      }else{
        $session = $_SESSION;
        $areas = Area::all();
        View::make('topic/new.html', array('errors' => $errors, 'attributes' => $attributes, 'areas' => $areas, 'session' => $session));
      }

    }

    public static function update($id){
      $params = $_POST;

      $attributes = array(
        'id' => $id,
        'area_id' => $params['area_id'],
        'player_id' => $params['player_id'],
        'name' => $params['name'],
      );

      $topic = new Topic($attributes);
      $errors = $topic->errors();

      if(strlen($params['msgtext']) < 1 || strlen($params['msgtext']) > 1000){
        $errors[] = 'Viestin pituus pitää olla vähintään 1 ja enintään 1000 merkkiä';
      }

      if(count($errors) == 0){
        $topic->update($id, $attributes);
        $firstmsg = Topic::firstTopicMessage($topic->id);
        $msg_id = $firstmsg->id;
        $messageAttributes = array(
          'id' => $msg_id,
          'player_id' => $params['player_id'],
          'topic_id' => $topic->id,
          'msgtext' => $params['msgtext']
        );

        $message = new Message($messageAttributes);
        $message->update($msg_id, $messageAttributes);

        Redirect::to('/topic/' . $topic->id, array('message' => 'Topic muokattiin onnistuneesti!'));

      }else{
        $first_message = Topic::firstTopicMessage($id);
        $session = $_SESSION;
        View::make('topic/edit.html', array('errors' => $errors, 'topic' => $topic, 'session' => $session, 'first_message' => $first_message));
      }
    }

    public static function destroy($id){
      $topic = new Topic(array('id' => $id));
      $topic->destroy($id);

      Redirect::to('/area', array('message' => 'Topic ja sen viestit poistettiin onnistuneesti'));
    }


  }
