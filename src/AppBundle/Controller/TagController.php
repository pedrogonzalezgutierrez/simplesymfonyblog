<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Tag;
use AppBundle\Form\TagType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class TagController extends Controller {
	
	/**
	 * @Route("/admin/tag/create", name="create_tag")
	 */
	public function createAction(Request $request) {
		
		$item=new Tag();
		
		// We are creating a new tag, so the action is 1		
		return $this->form($request, $item, 1);			
	}
	
	/**
	 * @Route("/admin/tag/update/{item}", name="update_tag")
	 */	
	public function updateAction(Request $request, Tag $item) {
		
		// We are updating a tag, so the action is 2
		return $this->form($request, $item, 2);
	}	
	
	private function form(Request $request, $item, $action) {
		
		// Create the form
		$form = $this->createForm(new TagType(), $item);
		
		$form->handleRequest($request);
		
		if($form->isValid()) {
			
			// The form is valid
			$em = $this->getDoctrine()->getManager();
			$em->persist($item);
			
			try {
				// Try to persist this tag 
				$em->flush();
				
			} catch(\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
				return $this->render('AppBundle:form:Exception.html.twig',
				array(
					'message' => $this->get('translator')->trans('error.exception.uniqueconstraintviolation')));				
			} catch(\Exception $e) {
				return $this->render('AppBundle:form:Exception.html.twig',
				array(
					'message' => $this->get('translator')->trans('error.exception.generic')));
			}
				
			// If we are here is because there was no exception
			return $this->redirect($this->generateUrl('manage_tags'));
		}
		
		return $this->render(
				'AppBundle:tag:form.html.twig',
				array(
						'action' => $action,
						'form' => $form->createView()
				)
		);
				
	}
	
	/**
	 * @Route("/admin/tag/delete/{item}", name="delete_tag")
	 */
	public function deleteAction(Tag $item) {
	
		// remove from data base
		$em = $this->getDoctrine()->getManager();
		$em->remove($item);
	
		try {
			// Try to remove this tag
			$em->flush();
	
		} catch(\Exception $e){
			return $this->render('AppBundle:form:Exception.html.twig',
					array(
							'message' => $this->get('translator')->trans('error.exception.generic')));
		}	
	
		// If we are here is because there was no exception
		return $this->redirect($this->generateUrl('manage_tags'));
	}
	
	
	/**
	 * @Route("/admin/tag/manage/{page}/{maxResults}", name="manage_tags", defaults={"page" = 1, "maxResults" = 15})
	 */	
	public function manageAction($page, $maxResults) {
		
		// Paginator sanitizer maxResults
		$maxResults=$this->get('app.utils')->paginatorCheckmaxResults($maxResults);
		// Calculate maxPages
		$maxPages=$this->getDoctrine()->getRepository('AppBundle:Tag')->getMaxPages($maxResults);
		// Paginator sanitizer page
		$page=$this->get('app.utils')->paginatorCheckpage($page,$maxPages);
		// Calculate firstResult
		$firstResult=$this->get('app.utils')->paginatorGetFirstResult($page,$maxResults);
	
		$tags=$this->getDoctrine()->getRepository('AppBundle:Tag')->findAllPaginatorByTagNameASC($firstResult,$maxResults);
		return $this->render(
				'AppBundle:tag:manage.html.twig',
				array(
					'items' => $tags,
					'page' => $page,
					'maxPages' => $maxPages,
					'maxResults' => $maxResults						
				)
		);
	
	}
	
	/**
	 * @Route("/show/tag/{tag}", name="show_tag", defaults={"title" = null})
	 */
	public function showAction(Tag $tag) {
	
		return $this->render('AppBundle:tag:show.html.twig',
				array(
						'tag' => $tag
				)
		);
	
	}
	
		
}