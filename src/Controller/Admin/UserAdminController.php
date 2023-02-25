<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserType;

#[Route('/admin/user')]
class UserAdminController extends AbstractController
{

    private $title = "Utilisateurs";

    #[Route('', name: 'admin_list_user')]
    public function userList(UserRepository $userRepository): Response
    {

        $users = $userRepository->findAll();

        return $this->render('admin/custom_list/user.html.twig', [
            "title" => $this->title,
            "users" => $users,
            "countEntity" => count($users),
            "newActionPath" => "admin_create_user",
        ]);

    }

    #[Route('/create', name: 'admin_create_user')]
    #[Route('/edit/{id}', name: 'admin_edit_user')]
    public function userForm(UserRepository $userRepository, EntityManagerInterface $em, Request $request, $id = false): Response
    {
        $user = new User();
        if($id)
        {
            $user = $userRepository->find($id);
        }
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $user->setRoles(["ROLE_USER", "ROLE_SUBSCRIBER"]);
            $em->persist($user);
            $em->flush();

            $this->addFlash("success", "L'utilisateur a bien été créé avec succès.");
            return $this->redirectToRoute("admin_list_user");
        }
        return $this->render('admin/default_form.html.twig', ["title" => $this->title, "form" => $form->createView()]);
    }

    #[Route('/delete/{id}', name: 'admin_delete_user')]
    public function userDelete($id, UserRepository $userRepository,  EntityManagerInterface $em): Response
    {
        $user = $userRepository->find($id);
        if(!$user){
            $this->addFlash('error', "L'utilisateur avec l'ID $id non trouvé.");
            return $this->redirectToRoute('admin_list_user');
        }

        $em->remove($user);
        $em->flush();

        $this->addFlash("success", "L'utilisateur $id a bien été supprimé.");

        return $this->redirectToRoute("admin_list_user");
    }

}