<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Helpers\GetAllArtists;
use App\Helpers\CheckUserAuth;

/**
 * @Route("/artist")
 */
class ArtistController extends AbstractController
{
  public function __construct(RequestStack $requestStack)
  {
    $this->requestStack = $requestStack;
  }
  /**
   * @Route("/", name="app_artist_index", methods={"GET"})
   */
  public function index(CheckUserAuth $validator): Response
  {
    if (!$validator->index()) {
      return $this->redirectToRoute('app_login_index', [], Response::HTTP_SEE_OTHER);
    }

    $api = new GetAllArtists();
    $artists = (array_flip($api->index()));
    
    return $this->render('artist/index.html.twig', [
      'artists' =>  $artists
    ]);
  }
}
