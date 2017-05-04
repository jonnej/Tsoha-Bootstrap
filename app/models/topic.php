<?php

  class Topic extends BaseModel{

    public $id, $area_id, $player_id, $name, $added, $modified;

    public function __construct($attributes){
      parent::__construct($attributes);
      $this->validators = array('validate_name');
  }

    public function save(){
      $query = DB::connection()->prepare('INSERT INTO Topic (area_id, player_id, name) VALUES (:area_id, :player_id, :name) RETURNING id');
      $query->execute(array('area_id' => $this->area_id, 'player_id' => $this->player_id, 'name' => $this->name));
      $row = $query->fetch();
      $this->id = $row['id'];
    }

    public function update($id, $attributes){
      $query = DB::connection()->prepare('UPDATE Topic SET (area_id, player_id, name) = (:area_id, :player_id, :name) WHERE id = :id');
      $query->execute(array('id' => $id, 'area_id' => $attributes['area_id'], 'player_id' => $attributes['player_id'], 'name' => $attributes['name']));

    }

    public function destroy($id) {
    $query = DB::connection()->prepare('DELETE FROM Topic WHERE id = :id');
    $query->execute(array('id' => $id));
}

    public static function find($id) {
      $query = DB::connection()->prepare('SELECT * FROM Topic WHERE id = :id');
      $query->execute(array('id' => $id));

      $row = $query->fetch();

      if($row){
        $topic = new Topic(array(
          'id' => $row['id'],
          'area_id' => $row['area_id'],
          'player_id' => $row['player_id'],
          'name' => $row['name'],
          'added' => $row['added'],
          'modified' => $row['modified']
        ));

        return $topic;
      }
        return null;
      }

    public static function findByArea($area_id){
      $query = DB::connection()->prepare('SELECT * FROM Topic WHERE area_id = :area_id');
      $query->execute(array('area_id' => $area_id));
      $rows = $query->fetchAll();
      $topics = array();

      foreach($rows as $row){
        $topics[] = new Topic(array(
        'id' => $row['id'],
        'area_id' => $row['area_id'],
        'player_id' => $row['player_id'],
        'name' => $row['name'],
        'added' => $row['added'],
        'modified' => $row['modified']
      ));

      }

      return $topics;
    }

    public static function find_by_name($name){
      $query = DB::connection()->prepare('SELECT * FROM Topic WHERE name ILIKE ?');
      $query->execute(array('%' . $name . '%'));
      $rows = $query->fetchAll();
      $topics = array();

      foreach($rows as $row){
        $topics[] = new Topic(array(
        'id' => $row['id'],
        'area_id' => $row['area_id'],
        'player_id' => $row['player_id'],
        'name' => $row['name'],
        'added' => $row['added'],
        'modified' => $row['modified']
      ));
      }
      return $topics;
    }


    public static function messageCount($topic_id){
      $query = DB::connection()->prepare('SELECT COUNT(*) FROM Message WHERE topic_id = :topic_id');
      $query->execute(array('topic_id' => $topic_id));
      $result = $query->fetch();

      echo $result[0];

    }

    public static function firstTopicMessage($topic_id){
      $query = DB::connection()->prepare('SELECT * FROM Message WHERE topic_id = :topic_id ORDER BY id ASC LIMIT 1');
      $query->execute(array('topic_id' => $topic_id));
      $row = $query->fetch();

      if($row){
        $message = new Message(array(
        'id' => $row['id'],
        'player_id' => $row['player_id'],
        'topic_id' => $row['topic_id'],
        'msgtext' => $row['msgtext'],
        'added' => $row['added'],
        'modified' => $row['modified']
      ));
      return $message;
      }
      return null;
    }

    public static function lastTopicMessage($topic_id){
      $query = DB::connection()->prepare('SELECT * FROM Message WHERE topic_id = :topic_id ORDER BY id DESC LIMIT 1');
      $query->execute(array('topic_id' => $topic_id));
      $row = $query->fetch();

      if($row){
        $message = new Message(array(
        'id' => $row['id'],
        'player_id' => $row['player_id'],
        'topic_id' => $row['topic_id'],
        'msgtext' => $row['msgtext'],
        'added' => $row['added'],
        'modified' => $row['modified']
      ));
      return $message;
      }
      return null;
    }

    public function validate_name(){
      $errors = array();

      if(strlen(preg_replace('/\s+/', '', $this->name)) < 3){
        $errors[] = 'Topicin nimessä pitää olla vähintään 3 merkkiä';
      }

      if(strlen($this->name) > 75){
        $errors[] = 'Topicin nimi ei saa olla yli 75 merkkiä';
      }

      return $errors;
    }





}
