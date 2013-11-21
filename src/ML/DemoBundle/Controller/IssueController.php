<?php

namespace ML\DemoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use ML\HydraBundle\Controller\HydraController;
use ML\HydraBundle\Mapping as Hydra;
use ML\HydraBundle\JsonLdResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ML\DemoBundle\Entity\Issue;
use ML\DemoBundle\Entity\Comment;

/**
 * Issue controller
 *
 * @Route("/issues")
 */
class IssueController extends HydraController
{
    /**
     * Retrieves all Issue entities
     *
     * @Route("/", name="issue_collection_retrieve")
     * @Method("GET")
     *
     * @Hydra\Operation()
     * @Hydra\Collection()
     *
     * @return array<ML\DemoBundle\Entity\Issue>
     */
    public function collectionGetAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MLDemoBundle:Issue')->findAll();

        return $entities;
    }

    /**
     * Creates a new Issue entity
     *
     * @Route("/", name="issue_create")
     * @Method("POST")
     *
     * @Hydra\Operation(
     *   expect = "ML\DemoBundle\Entity\Issue",
     *   status_codes = {
     *     "201" = "If the Issue entity was created successfully."
     * })
     *
     * @return ML\DemoBundle\Entity\Issue
     */
    public function collectionPostAction(Request $request)
    {
        $entity = $this->deserialize($request->getContent(), 'ML\DemoBundle\Entity\Issue');
        $entity->setRaisedBy($this->getUser());

        if (false !== ($errors = $this->validate($entity))) {
            return $errors;
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        $iri = $this->generateUrl('issue_retrieve', array('id' => $entity->getId()), true);

        $response = new JsonLdResponse(
            $this->serialize($entity),
            201,
            array('Content-Location' => $iri)
        );

        return $response;
    }

    /**
     * Retrieves a Issue entity
     *
     * @Route("/{id}", name="issue_retrieve")
     * @Method("GET")
     *
     * @Hydra\Operation()
     *
     * @return ML\DemoBundle\Entity\Issue
     */
    public function getAction(Issue $entity)
    {
        return $entity;
    }

    /**
     * Replaces an existing Issue entity
     *
     * @Route("/{id}", name="issue_replace")
     * @Method("PUT")
     *
     * @Hydra\Operation(
     *   expect = "ML\DemoBundle\Entity\Issue",
     *   status_codes = {
     *     "404" = "If the Issue entity wasn't found."
     *   }
     * )
     *
     * @return ML\DemoBundle\Entity\Issue
     */
    public function putAction(Request $request, Issue $entity)
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
     * Deletes a Issue entity
     *
     * @Route("/{id}", name="issue_delete")
     * @Method("DELETE")
     *
     * @Hydra\Operation()
     *
     * @return void
     */
    public function deleteAction(Request $request, Issue $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($entity);
        $em->flush();
    }

    /**
     * Retrieves all Comment entities for a specific issue
     *
     * @Route("/{id}/comments/", name="issue_comment_collection_retrieve")
     * @Method("GET")
     *
     * @Hydra\Operation()
     * @Hydra\Collection()
     *
     * @return array<ML\DemoBundle\Entity\Comment>
     */
    public function commentsGetAction(Issue $issue)
    {
        return $issue->getComments();
    }

    /**
     * Creates a new Comment for a specific issue
     *
     * To create a new Comment you have to be authenticated.
     *
     * @Route("/{id}/comments/", name="issue_comment_create")
     * @Method("POST")
     *
     * @Hydra\Operation(
     *   expect = "ML\DemoBundle\Entity\Comment",
     *   status_codes = {
     *     "404" = "If the Issue wasn't found."
     * })
     *
     * @return ML\DemoBundle\Entity\Comment
     */
    public function commentsPostAction(Request $request, Issue $issue)
    {
        $entity = $this->deserialize($request->getContent(), 'ML\DemoBundle\Entity\Comment');
        $entity->setIssue($issue);
        $entity->setUser($this->getUser());

        if (false !== ($errors = $this->validate($entity))) {
            return $errors;
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        $iri = $this->generateUrl('comment_retrieve', array('id' => $entity->getId()), true);

        $response = new JsonLdResponse(
            $this->serialize($entity),
            201,
            array('Content-Location' => $iri)
        );

        return $response;
    }
}
