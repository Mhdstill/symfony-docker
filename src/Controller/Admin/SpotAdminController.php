<?php

namespace App\Controller\Admin;

use App\Entity\SignalSpot;
use App\Repository\SignalSpotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SignalSpotType;

#[Route('/admin/spot')]
class SpotAdminController extends AbstractController
{

    private $title = "Signal Spot";

    #[Route('', name: 'admin_list_spot')]
    public function spotList(SignalSpotRepository $signalSpotRepository): Response
    {

        $spots = $signalSpotRepository->findAll();

        return $this->render('admin/custom_list/spot.html.twig', [
            "title" => $this->title,
            "spots" => $spots,
            "countEntity" => count($spots),
            "newActionPath" => "admin_create_spot",
        ]);

    }

    #[Route('/create', name: 'admin_create_spot')]
    #[Route('/edit/{id}', name: 'admin_edit_spot')]
    public function spotForm(SignalSpotRepository $signalSpotRepository, EntityManagerInterface $em, Request $request, $id = false): Response
    {
        $spot = new SignalSpot();
        if($id)
        {
            $spot = $signalSpotRepository->find($id);
        }
        $form = $this->createForm(SignalSpotType::class, $spot);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $spot = $form->getData();

            $em->persist($spot);
            $em->flush();

            $this->addFlash("success", "Le Signal Spot a bien été créé avec succès.");
            return $this->redirectToRoute("admin_list_spot");
        }
        return $this->render('admin/default_form.html.twig', ["title" => $this->title, "form" => $form->createView()]);
    }

    #[Route('/delete/{id}', name: 'admin_delete_spot')]
    public function spotDelete($id, SignalSpotRepository $signalSpotRepository,  EntityManagerInterface $em): Response
    {
        $spot = $signalSpotRepository->find($id);
        if(!$spot){
            $this->addFlash('error', "Signal Spot avec l'ID $id non trouvé.");
            return $this->redirectToRoute('admin_list_spot');
        }

        $em->remove($spot);
        $em->flush();

        $this->addFlash("success", "Le Signal Spot $id a bien été supprimé.");

        return $this->redirectToRoute("admin_list_spot");
    }

}