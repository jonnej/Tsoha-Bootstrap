<?php

  class Topic extends BaseModel{

    public $id, $area_id, $player_id, $name, $added, $modified;

    public function __construct($attributes){
      parent::__construct($attributes);
  }

  //   public static function all(){
  //
  //     $query = DB::connection()->prepare('SELECT * FROM Topic');
  //     $query->execute();
  //     $rows = $query->fetchAll();
  //     $topics = array();
  //
  //     foreach($rows as $row){
  //       $topics[] = new Topic(array(
  //       'id' => $row['id'],
  //       'area_id' => $row['area_id'],
  //       'player_id' => $row['player_id'],
  //       'name' => $row['name'],
  //       'added' => $row['added'],
  //       'modified' => $row['modified']
  //     ));
  //     }
  //
  //     return $topics
  // }
    // 
    // public static function topicsByAreaId($area_id){
    //   $query = DB::connection()->prepare('SELECT * FROM Topic WHERE area_id = :area_id');
    //   $query->execute(array('area_id' => $area_id));
    //   $rows = $query->fetchAll();
    //   $topics = array();
    //
    //   foreach($rows as $row){
    //     $topics = new Topic(array(
    //     'id' => $row['id'],
    //     'area_id' => $row['area_id'],
    //     'player_id' => $row['player_id'],
    //     'name' => $row['name'],
    //     'added' => $row['added'],
    //     'modified' => $row['modified']
    //   ));
    //   }
    //   Kint::dump($topics);
    //   return $topics;
    // }


    public static function messageCount($topic_id){
      $query = DB::connection()->prepare('SELECT COUNT(*) FROM Message WHERE topic_id = :topic_id');
      $query->execute(array('topic_id' => $topic_id));
      $result = $query->fetch();

      echo $result[0];

    }
}
