<?php

  class Area extends BaseModel{

    public $id, $player_id, $name, $description;

    public function __construct($attributes){
      parent::__construct($attributes);
      $this->validators = array('validate_name', 'validate_description');
  }

    public function save(){
      $query = DB::connection()->prepare('INSERT INTO Area (player_id, name, description) VALUES (:player_id, :name, :description) RETURNING id');
      $query->execute(array('player_id' => $this->player_id, 'name' => $this->name, 'description' => $this->description));
      $row = $query->fetch();
      $this->id = $row['id'];
  }

  public function destroy($id) {
  $query = DB::connection()->prepare('DELETE FROM Area WHERE id = :id');
  $query->execute(array('id' => $id));
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
      $query = DB::connection()->prepare('SELECT COUNT(*) FROM Message INNER JOIN Topic ON Message.topic_id = Topic.id WHERE Topic.area_id = :area_id');
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

    public function validate_name(){
      $errors = array();

      if(strlen(preg_replace('/\s+/', '', $this->name)) < 3){
        $errors[] = 'Alueen nimessä pitää olla vähintään 3 merkkiä';
      }

      if(strlen($this->name) > 50){
        $errors[] = 'Alueen nimi ei saa olla yli 50 merkkiä';
      }

      return $errors;
    }

    public function validate_description(){
      $errors = array();

      if(strlen(preg_replace('/\s+/', '', $this->description)) < 10){
        $errors[] = 'Alueen kuvaus pitää olla vähintään 10 merkkiä';
      }

      if(strlen($this->description) > 150){
        $errors[] = 'Alueen kuvaus ei saa olla yli 150 merkkiä';
      }

      return $errors;
    }


  }
