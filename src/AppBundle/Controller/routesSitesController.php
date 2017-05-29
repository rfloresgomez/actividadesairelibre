<?php

namespace AppBundle\Controller;

use AppBundle\Entity\routesSites;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Routessite controller.
 *
 * @Route("routessites")
 */
class routesSitesController extends Controller
{
    /**
     * Lists all routesSite entities.
     *
     * @Route("/", name="routessites_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $routesSites = $em->getRepository('AppBundle:routesSites')->findAll();

        return $this->render('routessites/index.html.twig', array(
            'routesSites' => $routesSites,
        ));
    }

    /**
     * Creates a new routesSite entity.
     *
     * @Route("/new", name="routessites_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $routesSite = new Routessite();
        $form = $this->createForm('AppBundle\Form\routesSitesType', $routesSite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($routesSite);
            $em->flush($routesSite);

            return $this->redirectToRoute('routessites_show', array('id' => $routesSite->getId()));
        }

        return $this->render('routessites/new.html.twig', array(
            'routesSite' => $routesSite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a routesSite entity.
     *
     * @Route("/{id}", name="routessites_show")
     * @Method("GET")
     */
    public function showAction(routesSites $routesSite)
    {
        $deleteForm = $this->createDeleteForm($routesSite);

        return $this->render('routessites/show.html.twig', array(
            'routesSite' => $routesSite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing routesSite entity.
     *
     * @Route("/{id}/edit", name="routessites_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, routesSites $routesSite)
    {
        $deleteForm = $this->createDeleteForm($routesSite);
        $editForm = $this->createForm('AppBundle\Form\routesSitesType', $routesSite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('routessites_edit', array('id' => $routesSite->getId()));
        }

        return $this->render('routessites/edit.html.twig', array(
            'routesSite' => $routesSite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a routesSite entity.
     *
     * @Route("/{id}", name="routessites_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, routesSites $routesSite)
    {
        $form = $this->createDeleteForm($routesSite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($routesSite);
            $em->flush($routesSite);
        }

        return $this->redirectToRoute('routessites_index');
    }

    /**
     * Creates a form to delete a routesSite entity.
     *
     * @param routesSites $routesSite The routesSite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(routesSites $routesSite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('routessites_delete', array('id' => $routesSite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
