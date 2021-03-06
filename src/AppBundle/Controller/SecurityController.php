<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * News controller.
 *
 */
class SecurityController extends Controller
{
    // src/AppBundle/Controller/SecurityController
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {

        if ($this->getUser() != null && in_array("ROLE_STANDARD", $this->getUser()->getRoles()))
            return $this->redirectToRoute('users_show', array('id' => $this->getUser()->getId()));

        // Recupera el servicio de autenticación
        $authenticationUtils = $this->get('security.authentication_utils');

        // Recupera, si existe, el último error al intentar hacer login
        $error = $authenticationUtils->getLastAuthenticationError();

        // Recupera el último nombre de usuario introducido
        $lastUsername = $authenticationUtils->getLastUsername();

//        dump($error);

        // Renderiza la plantilla, enviándole, si existen, el último error y nombre de usuario
        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(Request $request)
    {
        //
    }
}
