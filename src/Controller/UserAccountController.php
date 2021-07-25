<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditAccountType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserAccountController extends AbstractController
{
    /**
     * @Route("/user/account", name="user_account")
     */
    public function index(): Response{
        // IF NOT CONNECTED
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
    
        return $this->render('security/userAccount.html.twig');

    }

    /**
     * @Route("/user/account/edit", name="user_edit")
     */
    public function editAccount(Request $request): Response{
        
        $form = $this->createForm(EditAccountType::class, $this->getUser());
        $email = $this->getUser()->getEmail();
        $isverif = $this->getUser()->getIsverified();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $emailModify = $form->get('email')->getData();
            $isverifMod = $form->get('is_verified')->getData();
            
            if($isverif != $isverifMod){ // GENERATING ERROR IF USER WANT TO HACK VERIF BY DEVCONSOLE
                $this->addFlash(
                    'danger',
                    "Do not try this",
                );
                return $this->redirectToRoute('user_account');
            }
            if($emailModify != $email) {
                $user->setIsverified(false);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'success',
                "Contact Details have been modified successfully !",
            );

            return $this->redirectToRoute('user_account');
        }

        return $this->render('security/userEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}