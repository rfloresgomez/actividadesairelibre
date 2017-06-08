<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Images;
use AppBundle\Entity\Routes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Image controller.
 *
 * @Route("imagenes")
 */
class ImagesController extends Controller
{
    /**
     * Lists all image entities.
     *
     * @Route("/", name="images_index")
     * @Method("GET")
     */
    public function indexAction()
    {

        if ($this->getUser() == null)
            return $this->redirectToRoute('login');

        elseif ($this->getUser()->getRol() != "ADMIN")
            return $this->redirectToRoute('homepage');

        $em = $this->getDoctrine()->getManager();

        $images = $em->getRepository('AppBundle:Images')->findAll();

        return $this->render('images/index.html.twig', array(
            'images' => $images,
        ));
    }

    /**
     * Creates a new image entity.
     *
     * @Route("/new/{id}", name="images_new")
     */
    public function nuevaAction(Request $request, Routes $route)
    {

        if ($this->getUser() == null)
            return $this->redirectToRoute('login');

        $em = $this->getDoctrine()->getManager();

        $images = $em->getRepository('AppBundle:Images')->findAll();

        $image = new Images();
        $form = $this->createForm('AppBundle\Form\ImagesType', $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Recogemos el fichero
            $file = $form['image']->getData();
            if($file != null){
                // Sacamos la extensión del fichero
                $ext = $file->guessExtension();

                // Le ponemos un nombre al fichero
                $file_name = time() . "." . $ext;

                // Guardamos el fichero en el directorio uploads que estará en el directorio /web del framework
                $file->move("assets/images/galeries/", $file_name);

                // Establecemos el nombre de fichero en el atributo de la entidad
                $image->setImage($file_name);
            }else{
                $imageRadio = $request->get('imageSelect');
                $image->setImage($imageRadio);
                $image->setName("Imagen existente");
            }



            $image->setDate(new \DateTime("now"));
            $image->setIdRoute($route->getId());
//            $image->setIdUser(1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush($image);

            return $this->redirectToRoute('routes_show', array('id' => $route->getId()));
        }

        return $this->render('images/new.html.twig', array(
            'image' => $image,
            'form' => $form->createView(),
            'route' => $route,
            'images' => $images,
        ));
    }

    /**
     * Finds and displays a image entity.
     *
     * @Route("/{id}", name="images_show")
     * @Method("GET")
     */
    public function showAction(Images $image)
    {
        $deleteForm = $this->createDeleteForm($image);

        return $this->render('images/show.html.twig', array(
            'image' => $image,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing image entity.
     *
     * @Route("/{id}/edit", name="images_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Images $image)
    {
        $deleteForm = $this->createDeleteForm($image);
        $editForm = $this->createForm('AppBundle\Form\ImagesType', $image);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('images_edit', array('id' => $image->getId()));
        }

        return $this->render('images/edit.html.twig', array(
            'image' => $image,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a image entity.
     *
     * @Route("/{id}", name="images_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Images $image)
    {
        $form = $this->createDeleteForm($image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush($image);
        }

        return $this->redirectToRoute('images_index');
    }

    /**
     * Creates a form to delete a image entity.
     *
     * @param Images $image The image entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Images $image)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('images_delete', array('id' => $image->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
