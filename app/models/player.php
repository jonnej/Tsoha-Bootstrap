<?php

  class Player extends BaseModel{

    public $id, $nickname, $password, $created, $admin;

    public function __construct($attributes){
      parent::__construct($attributes);
  }


  }
