<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(WishRepository $repo): Response
    {

        $wishes=$repo->findBy(array('isPublished' =>1), array('dateCreated' => 'DESC'));#}

        return $this->render('main/home.html.twig', [
            'controller_name' => 'home',
            'wishes'=>$wishes,
        ]);
    }
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('main/contact.html.twig', [
            'controller_name' => 'contact',
        ]);
    }
    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('main/about.html.twig', [
            'controller_name' => 'about',
        ]);
    }
    /**
     * @Route("/wishes/{id}", name="wishes")
     */
    public function wishes(Wish $wish): Response
    {

        return $this->render('main/wishes.html.twig', [
            'wish' => $wish,
        ]);

    }

}
