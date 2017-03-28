<?php

  class Area extends BaseModel{

    public $id, $player_id, $name, $description;

    public function __construct($attributes){
      parent::__construct($attributes);
  }

    public static function all(){

      $query = DB::connection()->prepare('SELECT * FROM Area');
      $query->execute();
      $rows = $query->fetchAll();
      $areas = array();

      foreach($rows as $row){
        $areas[] = new Area(array(
        'id' => $row['id'],
        'player_id' => $row['player_id'],
        'name' => $row['name'],
        'description' => $row['description']
      ));
      }

      return $areas;
    }

    public static function find($id){
      $query = DB::connection()->prepare('SELECT * FROM Area WHERE id = :id');
      $query->execute(array('id' => $id));

      $row = $query->fetch();

      if($row){
        $area = new Area(array(
          'id' => $row['id'],
          'player_id' => $row['player_id'],
          'name' => $row['name'],
          'description' => $row['description']
        ));

        return $area;
      }
        return null;


    }

    public static function areaTopics($area_id){
      $query = DB::connection()->prepare('SELECT * FROM Topic WHERE area_id = :area_id');
      $query->execute(array('area_id' => $area_id));
      $rows = $query->fetchAll();
      $topics = array();

      foreach($rows as $row){
        $topics = new Topic(array(
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

    public static function topicCount($area_id){
      $query = DB::connection()->prepare('SELECT COUNT(*) FROM Topic WHERE area_id = :area_id');
      $query->execute(array('area_id' => $area_id));
      $result = $query->fetch();
      if ($result[0] == null) {
        echo 0;
      } else {
      echo $result[0];
    }
    }

    public static function messageCount($area_id){
      $query = DB::connection()->prepare('SELECT COUNT(*) AS result_count FROM Message INNER JOIN Topic ON Message.topic_id = Topic.id WHERE Topic.area_id = :area_id');
      $query->execute(array('area_id' => $area_id));
      $result = $query->fetch();

      echo $result[0];
    }

    public static function newestMessage($area_id){
      $query = DB::connection()->prepare('SELECT Message.* FROM Message INNER JOIN Topic ON Message.topic_id = Topic.id WHERE Topic.area_id = :area_id ORDER BY Message.added DESC LIMIT 1');
      $query->execute(array('area_id' => $area_id));
      $result = $query->fetch();


      return $result;
    }


  }
