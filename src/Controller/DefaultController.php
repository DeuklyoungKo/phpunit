<?php

namespace App\Controller;

use App\Entity\Enclosure;
use App\Repository\DinosaurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request)
    {

        $enclosures = $this->getDoctrine()
            ->getRepository(Enclosure::class)
            ->findAll();

        return $this->render('default/index.html.twig', [
            'enclosures' => $enclosures
        ]);
    }


    /**
     * @Route("/grow", name="grow_dinosaur", methods={"POST"})
     */
    public function growAction(Request $request, DinosaurRepository $dinosaurRepository)
    {
        $manager = $this->getDoctrine()->getManager();

        $enclosure = $manager->getRepository(Enclosure::class)
                             ->find($request->request->get('enclosure'));

        $specification = $request->request->get('specification');
        $dinosaur = $dinosaurRepository->growFromSpecification($specification);

        $dinosaur->setEnclosure($enclosure);
        $enclosure->addDinosaur($dinosaur);

        $manager->flush();

        $this->addFlash('success', sprintf(
            'Grew a %s in enclosure #%d',
            mb_strtolower($specification),
            $enclosure->getId()
        ));

        return $this->redirectToRoute('homepage');
    }


}
