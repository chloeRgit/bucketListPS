<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            'success_delete'=>'null',

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
            'success_ajout'=>'null',
        ]);

    }
    /**
     * @Route("/wish_ajout/", name="wish_ajout")
     */
    public function wishAjout(Request $request): Response
    {
        $wish=new Wish();
        //$now = date_create()->format('Y-m-d H:i:s');
        $wish->setIsPublished(true);
        $wish->setDateCreated(new \DateTime());
        $formWish=$this->createForm(WishType::class, $wish);
        $formWish->handleRequest($request);
        if($formWish->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($wish);
            $em->flush();
            return $this->render('main/wishes.html.twig', [
                'wish' => $wish,
                'success_ajout'=>'success']);
        }
        return $this->render('main/wish_ajout.html.twig', [
            'formWish' => $formWish->createView(),
            'success_ajout'=>'null',
        ]);

    }

    /**
     * @Route("/wish_update/{id}", name="wish_update")
     */
    public function wishUpdate(Wish $wish, Request $request): Response
    {

        $formWish = $this->createForm(WishType::class, $wish);
        $formWish->handleRequest($request);
        if ($formWish->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->render('main/wishes.html.twig', [
                'wish' => $wish,
                'success_ajout' => 'null']);
        }
        return $this->render('main/wish_update.html.twig', [
            'formWish' => $formWish->createView(),
            'success_ajout' => 'null',
        ]);
    }
        /**
         * @Route("/wish_delete/{id}", name="wish_delete")
         */
        public function wishdelete(Wish $wish, WishRepository $repo): Response
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($wish);
        $em->flush();
        $wishes=$repo->findBy(array('isPublished' =>1), array('dateCreated' => 'DESC'));
        return $this->render('main/home.html.twig', [
            'success_delete'=>'delete',
            'wishes'=>$wishes,
        ]);

    }



}
