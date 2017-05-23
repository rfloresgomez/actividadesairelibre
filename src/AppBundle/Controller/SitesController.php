<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sites;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Site controller.
 *
 * @Route("sites")
 */
class SitesController extends Controller
{
    /**
     * Lists all site entities.
     *
     * @Route("/", name="sites_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sites = $em->getRepository('AppBundle:Sites')->findAll();

        return $this->render('sites/index.html.twig', array(
            'sites' => $sites,
        ));
    }

    /**
     * Creates a new site entity.
     *
     * @Route("/new", name="sites_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $site = new Site();
        $form = $this->createForm('AppBundle\Form\SitesType', $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($site);
            $em->flush($site);

            return $this->redirectToRoute('sites_show', array('id' => $site->getId()));
        }

        return $this->render('sites/new.html.twig', array(
            'site' => $site,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a site entity.
     *
     * @Route("/{id}", name="sites_show")
     * @Method("GET")
     */
    public function showAction(Sites $site)
    {
        $deleteForm = $this->createDeleteForm($site);

        return $this->render('sites/show.html.twig', array(
            'site' => $site,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing site entity.
     *
     * @Route("/{id}/edit", name="sites_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Sites $site)
    {
        $deleteForm = $this->createDeleteForm($site);
        $editForm = $this->createForm('AppBundle\Form\SitesType', $site);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sites_edit', array('id' => $site->getId()));
        }

        return $this->render('sites/edit.html.twig', array(
            'site' => $site,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a site entity.
     *
     * @Route("/{id}", name="sites_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Sites $site)
    {
        $form = $this->createDeleteForm($site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($site);
            $em->flush($site);
        }

        return $this->redirectToRoute('sites_index');
    }

    /**
     * Creates a form to delete a site entity.
     *
     * @param Sites $site The site entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sites $site)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sites_delete', array('id' => $site->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
