<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Helpers\GetArtists;

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
  public function index(): Response
  {
    $api = new GetArtists();
    $artists = (array_flip($api->index()));
    // dump($artists);die;
    return $this->render('artist/index.html.twig', [
      'artists' =>  $artists
    ]);
  }
}
