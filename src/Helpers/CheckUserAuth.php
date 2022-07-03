<?php

namespace App\Helpers;
use Symfony\Component\HttpFoundation\RequestStack;

class CheckUserAuth {
  public function __construct(RequestStack $requestStack)
  {
      $this->requestStack = $requestStack;
  }
  public function index (){ 
    $session = $this->requestStack->getSession();
    $user = $session->get('user');
    if(!$user){
      return false;
    }
    return $user;
  }
}
