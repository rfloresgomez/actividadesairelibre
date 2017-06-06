<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Users;
use AppBundle\Entity\usersRoutes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("users")
 */
class UsersController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="users_index")
     * @Method("GET")
     */
    public function indexAction()
    {

        if ($this->getUser() == null)
            return $this->redirectToRoute('login');
        if ($this->getUser()->getRol() != "ADMIN")
            return $this->redirectToRoute('homepage');

        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:Users')->findAll();

        return $this->render('users/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="users_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $em = $this->getDoctrine()->getManager();
        $user = new Users();
        $user->setRol("STANDARD");
        $form = $this->createForm('AppBundle\Form\UsersType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {

            // Codificamos la contraseña en texto plano accediendo al 'encoder' que habíamos indicado en la configuración
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());

            // Establecemos la contraseña real ya codificada al usuario
            $user->setPassword($password);

//            $user->setPassword($user->getPlainPassword());

//            dump($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush($user);

            $message = \Swift_Message::newInstance()
                ->setSubject('Bienvenido')
                ->setFrom('r.carlosfloresgomez@gmail.com')
                ->setTo($user->getMail())
                ->setBody('Bienvenido "'.$user->getUsername().'", ya puedes comenzar a crear rutas y unirte a aquellas que más te gusten. Disfruta!!!');
            $this->get('mailer')->send($message);

            return $this->redirectToRoute('login');
        }

        return $this->render('users/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="users_show")
     * @Method("GET")
     */
    public function showAction(Users $user)
    {

        if ($this->getUser()->getRol() != 'ADMIN' && ($this->getUser() == null || $user->getId() != $this->getUser()->getId()))
            return $this->redirectToRoute("homepage");

        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($user);
        $repositoryUsersRoutes = $em->getRepository('AppBundle:usersRoutes');

        return $this->render('users/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
            'users_route' => $repositoryUsersRoutes->findBy(['idUser'=>$this->getUser()->getId()]),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="users_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Users $user)
    {

        if($this->getUser()->getRol() != 'ADMIN' && ($this->getUser() == null || $user->getId() != $this->getUser()->getId()))
            return $this->redirectToRoute('homepage');

        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('AppBundle\Form\UsersType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('users_edit', array('id' => $user->getId()));
        }

        return $this->render('users/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="users_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Users $user)
    {

        if($this->getUser()->getRol() != "ADMIN")
            return $this->redirectToRoute('homepage');

        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush($user);
        }

        return $this->redirectToRoute('users_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param Users $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Users $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('users_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
