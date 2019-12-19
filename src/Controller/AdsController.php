<?php

namespace App\Controller;

use App\Entity\Ads;
use App\Form\AdType;
use App\Repository\AdsRepository;
use App\Services\LanguagesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/ad", name="ads")
 */
class AdsController extends AbstractController
{
    /**
     * @Route("s", name=":index", methods={"HEAD","GET"})
     */
    public function index(AdsRepository $adsRepository): Response
    {
        $ads = $adsRepository->findAll();

        return $this->render('ads/index.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * @Route("", name=":create", methods={"HEAD","GET","POST"})
     */
    public function create(Request $request, ValidatorInterface $validator): Response
    {
        // 1. Check authenticated user
        // --

        $user = $this->getUser();

        if (null === $user)
        {
            $this->addFlash('warning', "You must be loged to create a new ad !");
            return $this->redirectToRoute('login');
        }

        // 2. Check user address
        // --

        // dd($user->getAddress());


        // 3. Retrieve Entities
        // --

        $em = $this->getDoctrine()->getManager();
        $ad = new Ads;


        // 4. Create Form
        // --

        // Init the form $errors array
        $errors = [];

        // Create new form based on the Ad Entity
        $form = $this->createForm(AdType::class, $ad);

        // Handle the Request (request method === post)
        $form->handleRequest($request);

        // On form submit
        if ($form->isSubmitted()) 
        {
            // Handle form errors
            $errors = $validator->validate($ad);

            // If the form is valid
            if ($form->isValid()) 
            {
                // $em = $this->getDoctrine()->getManager();

                // Set properties not defined by the form
                $ad->setLanguage( $user->getLanguage() );
                $ad->setCreatedBy( $user );

                $em->persist($ad);
                $em->flush();
            }
        }

        // Create the form view
        $form = $form->createView();

        return $this->render('ads/create.html.twig', [
            'form' => $form,
            'errors' => $errors,
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
