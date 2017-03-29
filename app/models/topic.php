<?php

  class Topic extends BaseModel{

    public $id, $area_id, $player_id, $name, $added, $modified;

    public function __construct($attributes){
      parent::__construct($attributes);
  }

    public function save(){

      $query = DB::connection()->prepare('INSERT INTO Topic (area_id, player_id, name) VALUES (:area_id, :player_id, :name) RETURNING id');
      $query->execute(array('area_id' => $this->area_id, 'player_id' => $this->player_id, 'name' => $this->name));
      $row = $query->fetch();
      $this->id = $row['id'];

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


    public static function messageCount($topic_id){
      $query = DB::connection()->prepare('SELECT COUNT(*) FROM Message WHERE topic_id = :topic_id');
      $query->execute(array('topic_id' => $topic_id));
      $result = $query->fetch();

      echo $result[0];

    }
}
