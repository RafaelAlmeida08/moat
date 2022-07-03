<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/login")
 */
class LoginController extends AbstractController
{
  private $doctrine;

  public function __construct(ManagerRegistry $doctrine)
  {
    $this->doctrine = $doctrine;
  }
    /**
     * @Route("/", name="app_login_index", methods={"GET", "POST"})
     */
    public function index(UserRepository $userRepository, Request $request): Response
    {
      $form = $this->createForm(LoginType::class);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $username = $form->get('username')->getData();
        $password = $form->get('password')->getData();
        $user = $userRepository->findOneByUsername($username);
        if(!$user || $user->getPassword() !== $password) {
          return new Response('Invalid credentials');
        }
        $session = new Session();
        $session->set('user', $user);
        return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
      }
        return $this->renderForm('login/index.html.twig', [
            'form' => $form
        ]);
    }
}
