<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/album")
 */
class AlbumController extends AbstractController
{
    /**
     * @Route("/", name="app_album_index", methods={"GET"})
     */
    public function index(AlbumRepository $albumRepository): Response
    {
        return $this->render('album/index.html.twig', [
            'albums' => $albumRepository->findAll(),
        ]);
    }
}
