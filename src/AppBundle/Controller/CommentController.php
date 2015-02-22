<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Comment;

class CommentController extends Controller {
	
	/**
	 * @Route("/admin/comment/delete/{comment}", name="delete_comment")
	 */	
	public function deleteAction(Comment $comment) {
	
		// remove from data base
		$em = $this->getDoctrine()->getManager();
		$em->remove($comment);
		
		try {
			// Try to delete
			$em->flush();
	
		} catch(\Exception $e){
			return $this->render('AppBundle:form:Exception.html.twig',
				array(
					'message' => $this->get('translator')->trans('error.exception.generic')));
		}	
		
	
		return $this->redirect($this->generateUrl('manage_comments'));
	}
	
	/**
	 * @Route("/admin/comment/accept/{comment}", name="accept_comment")
	 */	
	public function acceptAction(Comment $comment) {
	
		$comment->setCommentAccepted(true);
	
		$em = $this->getDoctrine()->getManager();
		$em->persist($comment);
			
		try {
			// Try to persist
			$em->flush();
	
		} catch(\Exception $e){
			return $this->render('AppBundle:form:Exception.html.twig',
				array(
					'message' => $this->get('translator')->trans('error.exception.generic')));
		}			
	
		return $this->redirect($this->generateUrl('manage_comments'));
	}
	
	/**
	 * @Route("/admin/comment/manage", name="manage_comments")
	 */	
	public function manageAction() {
	
		$items=$this->getDoctrine()->getRepository('AppBundle:Comment')->findAllByCommentAccepted(false);
	
		return $this->render(
				'AppBundle:comment:manage.html.twig',
				array(
						'items' => $items
				)
		);
	
	}
	
}