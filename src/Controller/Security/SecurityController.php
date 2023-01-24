<?php

namespace App\Controller\Security;

use App\Entity\Admin\ResetPassword;
use App\Form\Admin\ResetPasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="app.login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/security/login.html.twig', [
            'last_username'  =>  $lastUsername,
            'error'         =>  $error,
        ]);
    }

    /**
     * @Route("/security/home", name="home")
     */
    public function home()
    {
        $user = $this->getUser()->getStatus();
        if ($user === false) {
            return $this->redirectToRoute('edit-password');
        } else {
            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('admin_user_index');
            } elseif ($this->isGranted('ROLE_COMPTABLE')) {
                return $this->redirectToRoute('facturation_facture_index');
            } else {
                return $this->redirectToRoute('admin_user_index');
            }
        }
    }

    /**
     * @Route("/user/edit-password", name="edit-password", methods={"GET","POST"})
     */
    public function reset(Request $request, UserPasswordEncoderInterface $encoders)
    {
        $user = $this->getUser();
        $resetPassword = new ResetPassword();

        $form = $this->createForm(ResetPasswordType::class, $resetPassword);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newPassword = $resetPassword->getNewPassword();
            $hash = $encoders->encodePassword($user, $newPassword);
            $user->setPassword($hash);
            $user->setStatus(true);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Your password has been changed successfully');

            return $this->redirectToRoute('logout');
        }
        return $this->render('security/security/edit.html.twig', [
            'form'  => $form->createView(),
            'user'  => $user,
        ]);
    }

    public function redirectToLogin()
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('index');
        } else {
            return $this->redirectToRoute('login');
        }
    }
}
