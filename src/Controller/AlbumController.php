<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Helpers\CheckUserAuth;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Helpers\GetAllArtists;

/**
 * @Route("/album")
 */
class AlbumController extends AbstractController
{
  public function __construct(RequestStack $requestStack)
  {
    $this->requestStack = $requestStack;
  }
  /**
   * @Route("/", name="app_album_index", methods={"GET"})
   */
  public function index(AlbumRepository $albumRepository, CheckUserAuth $validator): Response
  {
    if (!$validator->index()) {
      return $this->redirectToRoute('app_login_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('album/index.html.twig', [
      'albums' =>  $this->getAlbums($albumRepository)
    ]);
  }

  /**
   * @Route("/new", name="app_album_new", methods={"GET", "POST"})
   */
  public function new(Request $request, AlbumRepository $albumRepository, CheckUserAuth $validator): Response
  {
    if (!$validator->index()) {
      return $this->redirectToRoute('app_login_index', [], Response::HTTP_SEE_OTHER);
    }
    $album = new Album();
    $form = $this->createForm(AlbumType::class, $album);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $albumRepository->add($album, true);

      return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('album/new.html.twig', [
      'album' => $album,
      'form' => $form,
    ]);
  }

  /**
   * @Route("/{id}", name="app_album_show", methods={"GET"})
   */
  public function show(AlbumRepository $albumRepository, Album $album, CheckUserAuth $validator): Response
  {
    if (!$validator->index()) {
      return $this->redirectToRoute('app_login_index', [], Response::HTTP_SEE_OTHER);
    }
    return $this->render('album/show.html.twig', [
      'album' => $this->getAlbum($albumRepository, $album->getId()),
      'role' => $this->getUserRole()
    ]);
  }

  /**
   * @Route("/{id}/edit", name="app_album_edit", methods={"GET", "POST"})
   */
  public function edit(Request $request, Album $album, AlbumRepository $albumRepository, CheckUserAuth $validator): Response
  {
    if (!$validator->index()) {
      return $this->redirectToRoute('app_login_index', [], Response::HTTP_SEE_OTHER);
    }
    $form = $this->createForm(AlbumType::class, $album);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $albumRepository->add($album, true);

      return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('album/edit.html.twig', [
      'album' => $album,
      'form' => $form,
      'role' => $this->getUserRole()
    ]);
  }

  /**
   * @Route("/{id}", name="app_album_delete", methods={"POST"})
   */
  public function delete(Request $request, Album $album, AlbumRepository $albumRepository, CheckUserAuth $validator): Response
  {
    if (!$validator->index()) {
      return $this->redirectToRoute('app_login_index', [], Response::HTTP_SEE_OTHER);
    }
    if ($this->isCsrfTokenValid('delete' . $album->getId(), $request->request->get('_token'))) {
      $albumRepository->remove($album, true);
    }

    return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
  }

  private function getUserRole(): int
  {
    $session = $this->requestStack->getSession();
    $user = $session->get('user');
    return $user->getRole();
  }

  private function getAlbums(AlbumRepository $albumRepository)
  {
    $api = new GetAllArtists();
    $artists = ($api->index());
    $albums =  $albumRepository->findAll();

    foreach ($albums as $album) {
      $album->SetArtist(array_search(
        $album->getArtist(),
        $artists
      ));
    }
    return $albums;
  }

  private function getAlbum(AlbumRepository $albumRepository, $id)
  {
    $api = new GetAllArtists();
    $artists = ($api->index());
    $album =  $albumRepository->find($id);
    $album->SetArtist(array_search(
      $album->getArtist(),
      $artists
    ));
    return $album;
  }
}
