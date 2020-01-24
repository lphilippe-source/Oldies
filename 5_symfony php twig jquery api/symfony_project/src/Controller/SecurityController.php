<?php

namespace App\Controller;

use App\Entity\UserData;
use App\Form\FormConnectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder){
        $user= new UserData;
        $form=$this->createForm(FormConnectType::class, $user);// $user full with form
        $form->HandleRequest($request);// analyse request
        // dump($user->getDate());
        // var_dump(new \DateTime());
        if($form->isSubmitted() && $form->isValid()){ //si form is valid and POST

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setDate(new \DateTime);
            $entityManager->persist($user);//make persist the user
            $entityManager->flush($user); //make it real in db

            return $this->redirectToRoute('security_login');
        }
        return $this->render('security/registration.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @route("/login", name="security_login")
     */
    public function login(){
        return $this->render('security/login.html.twig');
    }
    /**
     * @route("/logout", name="logout")
     */
    public function logout(){}
}
