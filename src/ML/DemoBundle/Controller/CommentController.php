<?php

namespace ML\DemoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use ML\HydraBundle\Controller\HydraController;
use ML\HydraBundle\Mapping as Hydra;
use ML\HydraBundle\JsonLdResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ML\DemoBundle\Entity\Comment;

/**
 * Comment controller
 *
 * @Route("/comments")
 */
class CommentController extends HydraController
{
    /**
     * Retrieves a Comment
     *
     * @Route("/{id}", name="comment_retrieve")
     * @Method("GET")
     *
     * @Hydra\Operation(
     *   status_codes = {
     *     "404" = "If the Comment entity wasn't found."
     * })
     *
     * @return ML\DemoBundle\Entity\Comment
     */
    public function getAction(Comment $entity)
    {
        return $entity;
    }

    /**
     * Replaces an existing Comment
     *
     * @Route("/{id}", name="comment_replace")
     * @Method("PUT")
     *
     * @Hydra\Operation(
     *   expect = "ML\DemoBundle\Entity\Comment",
     *   status_codes = {
     *     "404" = "If the Comment wasn't found."
     *   }
     * )
     *
     * @return ML\DemoBundle\Entity\Comment
     */
    public function putAction(Request $request, Comment $entity)
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
     * Deletes a Comment
     *
     * @Route("/{id}", name="comment_delete")
     * @Method("DELETE")
     *
     * @Hydra\Operation(
     *   status_codes = {
     *     "404" = "If the Comment entity wasn't found."
     * })
     *
     * @return void
     */
    public function deleteAction(Request $request, Comment $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($entity);
        $em->flush();
    }
}
