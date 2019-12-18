<?php

namespace App\Controller;

use App\Services\LanguagesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage", methods={"HEAD","GET"})
     */
    public function index(LanguagesService $languages)
    {
        // dump( "getAcceptedLanguages", $languages->getAcceptedLanguages() );
        // dump( "getMainLanguage", $languages->getMainLanguage() );
        // dump( "getMainLocale", $languages->getMainLocale() );
        // dump( "getMainRegion", $languages->getMainRegion() );
        // exit;

        return $this->redirectToRoute('ads:index');
    }
    /**
     * @Route("/contact", name="contact", methods={"HEAD","GET","POST"})
     */
    public function contact()
    {
        $form = null;
        return $this->render('contact/index.html.twig', [
            'form' => $form
        ]);
    }
    /**
     * @Route("/terms-of-use", name="legal", methods={"HEAD","GET"})
     */
    public function legal()
    {
        return $this->render('legal/index.html.twig');
    }
}
