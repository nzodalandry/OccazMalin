<?php

namespace App\Controller;

use App\Repository\AdsRepository;
use App\Services\LanguagesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ad", name="ads")
 */
class AdsController extends AbstractController
{
    /**
     * @Route("s", name=":index", methods={"HEAD","GET"})
     */
    public function index(AdsRepository $adsRepository)
    {
        $ads = $adsRepository->findAll();

        return $this->render('ads/index.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * @Route("", name=":create", methods={"HEAD","GET","POST"})
     */
    public function create()
    {
        // Check authenticated user
        $user = $this->getUser();

        if (null === $user)
        {
            $this->addFlash('warning', "You must be loged to create a new ad !");
            return $this->redirectToRoute('login');
        }


        return $this->render('ads/create.html.twig', [
        ]);
    }

    /**
     * @Route("/{id}", name=":read", methods={"HEAD","GET"})
     */
    public function read()
    {
        return $this->render('ads/read.html.twig', [
        ]);
    }

    /**
     * @Route("/{id}/edit", name=":update", methods={"HEAD","GET","POST"})
     */
    public function update()
    {
        return $this->render('ads/update.html.twig', [
        ]);
    }

    /**
     * @Route("/{id}/delete", name=":delete", methods={"HEAD","GET","DELETE"})
     */
    public function delete()
    {
        return $this->render('ads/delete.html.twig', [
        ]);
    }
}
