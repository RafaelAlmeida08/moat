<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Persistence\ManagerRegistry;

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
      }
        return $this->renderForm('login/index.html.twig', [
            'form' => $form
        ]);
    }
}