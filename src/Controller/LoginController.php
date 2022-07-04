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
use Symfony\Component\HttpFoundation\RequestStack;

class LoginController extends AbstractController
{
  
  public function __construct(ManagerRegistry $doctrine, RequestStack $requestStack)
  {
    $this->doctrine = $doctrine;
    $this->requestStack = $requestStack;
  }
  /**
   * @Route("/login", name="app_login_index", methods={"GET", "POST"})
   */
  public function index(UserRepository $userRepository, Request $request): Response
  {
    $form = $this->createForm(LoginType::class);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $username = $form->get('username')->getData();
      $password = $form->get('password')->getData();
      $user = $userRepository->findOneByUsername($username);
      if (!$user || $user->getPassword() !== $password) {
        $this->addFlash('failed_login', "Sorry, we couldn't find an account with this username. Please check you're using the right username and try again.");
      }
      $session = new Session();
      $session->set('user', $user);
      return $this->redirectToRoute('app_album_index', [], Response::HTTP_SEE_OTHER);
    }
    return $this->renderForm('login/index.html.twig', [
      'form' => $form
    ]);
  }
   /**
   * @Route("/logout", name="app_logout", methods={"GET", "POST"})
   */
  public function logout(Request $request): Response
  {
    $form = $this->createForm(LoginType::class);
    $form->handleRequest($request);

    $session = $this->requestStack->getSession();
    $session->clear();
    return $this->renderForm('login/index.html.twig', [
      'form' => $form
    ]);
  }
}
