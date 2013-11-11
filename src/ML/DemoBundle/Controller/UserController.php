<?php

namespace ML\DemoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use ML\HydraBundle\Controller\HydraController;
use ML\HydraBundle\Mapping as Hydra;
use ML\HydraBundle\JsonLdResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ML\DemoBundle\Entity\User;

/**
 * User controller
 *
 * @Route("/users")
 */
class UserController extends HydraController
{
    /**
     * Retrieves all User entities
     *
     * @Route("/", name="user_collection_retrieve")
     * @Method("GET")
     *
     * @Hydra\Operation()
     * @Hydra\Collection()
     *
     * @return array<ML\DemoBundle\Entity\User>
     */
    public function collectionGetAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MLDemoBundle:User')->findAll();

        return $entities;
    }

    /**
     * Creates a new User entity
     *
     * @Route("/", name="user_create")
     * @Method("POST")
     *
     * @Hydra\Operation(
     *   status_codes = {
     *     "201" = "If the User entity was created successfully."
     * })
     *
     * @Hydra\Operation(expect = "ML\DemoBundle\Entity\User")
     *
     * @return ML\DemoBundle\Entity\User
     */
    public function collectionPostAction(Request $request)
    {
        $entity = $this->deserialize($request->getContent(), 'ML\DemoBundle\Entity\User');

        if (false !== ($errors = $this->validate($entity))) {
            return $errors;
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        $iri = $this->generateUrl('user_retrieve', array('id' => $entity->getId()), true);

        $response = new JsonLdResponse(
            $this->serialize($entity),
            201,
            array('Content-Location' => $iri)
        );

        return $response;
    }

    /**
     * Retrieves a User entity
     *
     * @Route("/{id}", name="user_retrieve")
     * @Method("GET")
     *
     * @Hydra\Operation()
     *
     * @return ML\DemoBundle\Entity\User
     */
    public function getAction(User $entity)
    {
        return $entity;
    }

    /**
     * Replaces an existing User entity
     *
     * @Route("/{id}", name="user_replace")
     * @Method("PUT")
     *
     * @Hydra\Operation(
     *   expect = "ML\DemoBundle\Entity\User",
     *   status_codes = {
     *     "404" = "If the User entity wasn't found."
     *   }
     * )
     *
     * @return ML\DemoBundle\Entity\User
     */
    public function putAction(Request $request, User $entity)
    {
        $entity = $this->deserialize($request->getContent(), $entity);

        if (false !== ($errors = $this->validate($entity))) {
            return $errors;
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        return $entity;
    }

    /**
     * Deletes a User entity
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     *
     * @Hydra\Operation()
     *
     * @return void
     */
    public function deleteAction(Request $request, User $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($entity);
        $em->flush();
    }

    /**
     * Retrieves the issues raised by a User entity
     *
     * @Route("/{id}/raised_issues", name="user_raised_issues_retrieve")
     * @Method("GET")
     *
     * @Hydra\Operation(
     *   status_codes = {
     *     "404" = "If the User entity wasn't found."
     * })
     * @Hydra\Collection()
     *
     * @return ArrayCollection<ML\DemoBundle\Entity\Issue>
     */
    public function getRaisedIssuesAction(User $entity)
    {
        return $entity->getRaisedIssues();
    }
}
