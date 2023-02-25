<?php

namespace App\Controller\Admin;

use App\Entity\SignalFutur;
use App\Form\SignalFuturType;
use App\Repository\SignalFuturRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/futur')]
class FuturAdminController extends AbstractController
{

    private $title = "Signal Futur";

    #[Route('', name: 'admin_list_futur')]
    public function futurList(SignalFuturRepository $signalFuturRepository): Response
    {

        $futurs = $signalFuturRepository->findAll();

        return $this->render('admin/custom_list/futur.html.twig', [
            "title" => $this->title,
            "futurs" => $futurs,
            "countEntity" => count($futurs),
            "newActionPath" => "admin_create_futur",
        ]);

    }

    #[Route('/create', name: 'admin_create_futur')]
    #[Route('/edit/{id}', name: 'admin_edit_futur')]
    public function futurForm(SignalFuturRepository $signalFuturRepository, EntityManagerInterface $em, Request $request, $id = false): Response
    {
        $futur = new SignalFutur();
        if($id)
        {
            $futur = $signalFuturRepository->find($id);
        }
        $form = $this->createForm(SignalFuturType::class, $futur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $futur = $form->getData();

            $em->persist($futur);
            $em->flush();

            $this->addFlash("success", "Le Signal Futur a bien été créé avec succès.");
            return $this->redirectToRoute("admin_list_futur");
        }
        return $this->render('admin/default_form.html.twig', ["title" => $this->title, "form" => $form->createView()]);
    }

    #[Route('/delete/{id}', name: 'admin_delete_futur')]
    public function futurDelete($id, SignalFuturRepository $signalFuturRepository,  EntityManagerInterface $em): Response
    {
        $futur = $signalFuturRepository->find($id);
        if(!$futur){
            $this->addFlash('error', "Signal Futur avec l'ID $id non trouvé.");
            return $this->redirectToRoute('admin_list_futur');
        }

        $em->remove($futur);
        $em->flush();

        $this->addFlash("success", "Le Signal Futur $id a bien été supprimé.");

        return $this->redirectToRoute("admin_list_futur");
    }

}