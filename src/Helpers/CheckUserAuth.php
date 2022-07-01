<?php

namespace App\Helpers;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserAuth {

  public function index (Request $request){ 
    if(!isset($_SESSION['user'])){
      return;
    }
  }
}
