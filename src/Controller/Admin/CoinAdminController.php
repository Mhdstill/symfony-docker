<?php

namespace App\Controller\Admin;

use App\Entity\Coin;
use App\Entity\MediaObject;
use App\Form\CoinType;
use App\Repository\CoinRepository;
use App\Service\FileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/coin')]
class CoinAdminController extends AbstractController
{

    private $title = "Coin";

    #[Route('', name: 'admin_list_coin')]
    public function coinList(CoinRepository $coinRepository): Response
    {

        $coins = $coinRepository->findAll();

        return $this->render('admin/custom_list/coin.html.twig', [
            "title" => $this->title,
            "coins" => $coins,
            "countEntity" => count($coins),
            "newActionPath" => "admin_create_coin",
        ]);

    }

    #[Route('/create', name: 'admin_create_coin')]
    #[Route('/edit/{id}', name: 'admin_edit_coin')]
    public function coinForm( SluggerInterface $slugger, FileService $fileService,CoinRepository $coinRepository, EntityManagerInterface $em, Request $request, $id = false): Response
    {
        $coin = new Coin();
        if($id)
        {
            $coin = $coinRepository->find($id);
        }
        $form = $this->createForm(CoinType::class, $coin);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coin = $form->getData();

            if ($file = $form->get('image')->getData()) {
                $extension = $file->guessExtension();
                $fileName = $slugger->slug($coin->getName())->lower() . '.' . $extension;
                $destination = $this->getParameter('kernel.project_dir') . '/public/media/';
                $uploadedFile = $fileService->uploadFile($file, $destination, $fileName);
                if (!$uploadedFile) {
                    $this->addFlash("error", "Problème sur l'import de fichier.");
                    return $this->redirectToRoute("admin_list_team");
                }
                
                $image = new MediaObject();
                $image->setName($fileName);
                $coin->setImage($image);
            }


            $em->persist($coin);
            $em->flush();

            $this->addFlash("success", "Le Coin a bien été créé avec succès.");
            return $this->redirectToRoute("admin_list_coin");
        }
        return $this->render('admin/default_form.html.twig', ["title" => $this->title, "form" => $form->createView()]);
    }

    #[Route('/delete/{id}', name: 'admin_delete_coin')]
    public function coinDelete($id, CoinRepository $coinRepository,  EntityManagerInterface $em): Response
    {
        $coin = $coinRepository->find($id);
        if(!$coin){
            $this->addFlash('error', "Coin avec l'ID $id non trouvé.");
            return $this->redirectToRoute('admin_list_coin');
        }

        $em->remove($coin);
        $em->flush();

        $this->addFlash("success", "Le Coin $id a bien été supprimé.");

        return $this->redirectToRoute("admin_list_coin");
    }

}