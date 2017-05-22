<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Routes;
use AppBundle\Model\usersRoutesData;
use AppBundle\Repository\usersRoutesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Route controller.
 *
 * @Route("/")
 */
class RoutesController extends Controller
{
    /**
     * Lists all route entities.
     *
     * @Route("/", name="homepage")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $routes = $em->getRepository('AppBundle:Routes')->findAll();
        /** @var usersRoutesRepository $repositoryUsersRoutes */
        $repositoryUsersRoutes = $em->getRepository('AppBundle:usersRoutes');
        $rutasUnidas = $repositoryUsersRoutes->findBy(['idUser'=>$this->getUser()->getId()]);
        $data = [];
        foreach ($routes as $route){
            $usersRoutes = $repositoryUsersRoutes->findByIdRoute($route->getId());
            $data[] = new usersRoutesData($route, $usersRoutes);
        }

        return $this->render('routes/index.html.twig', array(
            'routes' => $data,
            'userLoged' => $this->getUser(),
            'rutasUnidas' => $rutasUnidas,
        ));
    }

    /**
     * Lists all route entities.
     *
     * @Route("list", name="list_routes")
     * @Method("GET")
     */
    public function listAction()
    {

        if($this->getUser()->getRol() == null || $this->getUser()->getRol() != "ADMIN")
            $this->redirectToRoute('homepage');

        $em = $this->getDoctrine()->getManager();

        $routes = $em->getRepository('AppBundle:Routes')->findAll();

        return $this->render(':routes:listado.html.twig', array(
            'route' => $routes,
        ));
    }

    /**
     * Creates a new route entity.
     *
     * @Route("routes/new", name="routes_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        if ($this->getUser() == null)
            return $this->redirectToRoute('login');

        $route = new Routes();
        $route->setCreatedDate(new \DateTime("now"));
        $route->setUpdatedDate(new \DateTime("now"));
        $route->setOwner($this->getUser()->getId());
        $form = $this->createForm('AppBundle\Form\RoutesType', $route);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($route);
            $em->flush($route);

            return $this->redirectToRoute('routes_show', array('id' => $route->getId()));
        }

        return $this->render('routes/new.html.twig', array(
            'route' => $route,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a route entity.
     *
     * @Route("routes/{id}", name="routes_show")
     * @Method("GET")
     */
    public function showAction(Routes $route)
    {
        $deleteForm = $this->createDeleteForm($route);

        return $this->render('routes/show.html.twig', array(
            'route' => $route,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing route entity.
     *
     * @Route("routes/{id}/edit", name="routes_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Routes $route)
    {
        if ($this->getUser() == null)
            return $this->redirectToRoute('login');

        if($this->getUser()->getRol() != 'ADMIN' && $route->getOwner() != $this->getUser()->getId())
            return $this->redirectToRoute('homepage');

        $deleteForm = $this->createDeleteForm($route);
        $editForm = $this->createForm('AppBundle\Form\RoutesType', $route);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $route->setUpdatedDate(new \DateTime("now"));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('routes_show', array('id' => $route->getId()));
        }

        return $this->render('routes/edit.html.twig', array(
            'route' => $route,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a route entity.
     *
     * @Route("routes/{id}", name="routes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Routes $route)
    {

        if($this->getUser()->getRol() != 'ADMIN' && ($this->getUser() == null || $route->getOwner() != $this->getUser()->getId()))
            return $this->redirectToRoute('homepage');

        $form = $this->createDeleteForm($route);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($route);
            $em->flush($route);
        }

        return $this->redirectToRoute('routes_index');
    }

    /**
     * Creates a form to delete a route entity.
     *
     * @param Routes $route The route entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Routes $route)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('routes_delete', array('id' => $route->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
