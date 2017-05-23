<?php

namespace AppBundle\Controller;

use AppBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * News controller.
 *
 * @Route("news")
 */
class NewsController extends Controller
{
    /**
     * Lists all news entities.
     *
     * @Route("/", name="news_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $news = $em->getRepository('AppBundle:News')->findAll();

        return $this->render('news/index.html.twig', array(
            'news' => $news,
        ));
    }

    /**
     * Creates a new news entity.
     *
     * @Route("/new", name="news_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        if ($this->getUser() == null)
            return $this->redirectToRoute("login");
        elseif ($this->getUser()->getROl() == 'STANDARD')
            return $this->redirectToRoute("news_index");


        $news = new News();
        $news->setOwner($this->getUser()->getId());
        $form = $this->createForm('AppBundle\Form\NewsType', $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Recogemos el fichero
            $file = $form['image']->getData();

            if($file == null)
                $news->setImage(null);
            else {

                // Sacamos la extensión del fichero
                $ext = $file->guessExtension();

                // Le ponemos un nombre al fichero
                $file_name = time() . "." . $ext;

                // Guardamos el fichero en el directorio uploads que estará en el directorio /web del framework
                $file->move("assets/images/news", $file_name);

                // Establecemos el nombre de fichero en el atributo de la entidad
                $news->setImage($file_name);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush($news);

            return $this->redirectToRoute('news_show', array('id' => $news->getId()));
        }

        return $this->render('news/new.html.twig', array(
            'news' => $news,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a news entity.
     *
     * @Route("/{id}", name="news_show")
     * @Method("GET")
     */
    public function showAction(News $news)
    {
        $deleteForm = $this->createDeleteForm($news);

        return $this->render('news/show.html.twig', array(
            'news' => $news,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing news entity.
     *
     * @Route("/{id}/edit", name="news_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, News $news)
    {
        if ($this->getUser() == null)
            return $this->redirectToRoute('login');

        if ($this->getUser()->getRol() != 'ADMIN' && $news->getOwner() != $this->getUser()->getId())
            return $this->redirectToRoute('news_index');

        $image = $news->getImage();
        $news->setImage(null);
        $deleteForm = $this->createDeleteForm($news);
        $editForm = $this->createForm('AppBundle\Form\NewsType', $news);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // Recogemos el fichero
            $file = $editForm['image']->getData();

            if($file == null)
                $news->setImage($image);
            else {

                // Sacamos la extensión del fichero
                $ext = $file->guessExtension();

                // Le ponemos un nombre al fichero
                $file_name = time() . "." . $ext;

                // Guardamos el fichero en el directorio uploads que estará en el directorio /web del framework
                $file->move("assets/images/news", $file_name);

                // Establecemos el nombre de fichero en el atributo de la entidad
                $news->setImage($file_name);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('news_show', array('id' => $news->getId()));
        }

        return $this->render('news/edit.html.twig', array(
            'news' => $news,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a news entity.
     *
     * @Route("/{id}", name="news_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, News $news)
    {

        if ($this->getUser()->getRol() != 'ADMIN' && ($this->getUser() == null || $news->getOwner() != $this->getUser()->getId()))
            return $this->redirectToRoute('news_index');

        $form = $this->createDeleteForm($news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($news);
            $em->flush($news);
        }

        return $this->redirectToRoute('news_index');
    }

    /**
     * Creates a form to delete a news entity.
     *
     * @param News $news The news entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(News $news)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('news_delete', array('id' => $news->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
