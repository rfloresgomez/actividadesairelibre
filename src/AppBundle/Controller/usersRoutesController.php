<?php

namespace AppBundle\Controller;

use AppBundle\Entity\usersRoutes;
use AppBundle\Entity\Routes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Usersroute controller.
 *
 * @Route("usersroutes")
 */
class usersRoutesController extends Controller
{
    /**
     * Lists all usersRoute entities.
     *
     * @Route("/", name="usersroutes_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usersRoutes = $em->getRepository('AppBundle:usersRoutes')->findAll();

        return $this->render('usersroutes/index.html.twig', array(
            'usersRoutes' => $usersRoutes,
        ));
    }

    /**
     * Creates a new usersRoute entity.
     *
     * @Route("/new/{id}", name="usersroutes_new")
     */
    public function nuevaAction(Routes $route)
    {

        if ($this->getUser() == null)
            return $this->redirectToRoute("login");

        $usersRoute = new usersRoutes();
        $usersRoute->setIdUser($this->getUser());
        $usersRoute->setIdRoute($route);
        $em = $this->getDoctrine()->getManager();
        $em->persist($usersRoute);
        $em->flush($usersRoute);
        return $this->redirectToRoute('homepage');
    }

    /**
     * Deletes a usersRoute entity.
     *
     * @Route("/{id}", name="usersroutes_delete")
     * @Method("GET")
     */
    public function borrarAction(Routes $route)
    {

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:usersRoutes');
        $usersRoute = $repository->findOneBy(['idUser'=>$this->getUser()->getId(),
                                            'idRoute'=>$route->getId()]);
        $em->remove($usersRoute);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }

    /**
     * Creates a form to delete a usersRoute entity.
     *
     * @param usersRoutes $usersRoute The usersRoute entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(usersRoutes $usersRoute)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usersroutes_delete', array('id' => $usersRoute->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
