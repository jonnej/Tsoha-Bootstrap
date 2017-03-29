<?php

  class Player extends BaseModel{

    public $id, $nickname, $password, $created, $admin;

    public function __construct($attributes){
      parent::__construct($attributes);
  }

    public function save(){
      $query = DB::connection()->prepare('INSERT INTO Player (nickname, password) VALUES (:nickname, :password) RETURNING id');
      $query->execute(array('nickname' => $this->nickname, 'password' => $this->password));
      $row = $query->fetch();
      $this->id = $row['id'];

}


  }
