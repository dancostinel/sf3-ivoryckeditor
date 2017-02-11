<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Example;
use AppBundle\Form\ExampleType;

/**
 * Example controller.
 *'submit'
 */
class ExampleController extends Controller
{
    /**
     * Lists all Example entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Example')->findAll();
        return $this->render('AppBundle:Example:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Example entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Example();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('example_show', array('id' => $entity->getId())));
        }
        return $this->render('AppBundle:Example:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Example entity.
     *
     * @param Example $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Example $entity)
    {
        $form = $this->createForm(ExampleType::class, $entity, array(
            'action' => $this->generateUrl('example_create'),
            'method' => 'POST',
        ));
        $form->add('submit', SubmitType::class, array('label' => 'Create'));
        return $form;
    }

    /**
     * Displays a form to create a new Example entity.
     *
     */
    public function newAction()
    {
        $entity = new Example();
        $form   = $this->createCreateForm($entity);
        return $this->render('AppBundle:Example:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Example entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Example')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Example entity.');
        }
        $deleteForm = $this->createDeleteForm($id);
        return $this->render('AppBundle:Example:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Example entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Example')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Example entity.');
        }
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        return $this->render('AppBundle:Example:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Example entity.
    *
    * @param Example $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Example $entity)
    {
        $form = $this->createForm(ExampleType::class, $entity, array(
            'action' => $this->generateUrl('example_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('submit', SubmitType::class, array('label' => 'Update'));
        return $form;
    }

    /**
     * Edits an existing Example entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Example')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Example entity.');
        }
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('example_edit', array('id' => $id)));
        }
        return $this->render('AppBundle:Example:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Example entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Example')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Example entity.');
            }
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('example'));
    }

    /**
     * Creates a form to delete a Example entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('example_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
