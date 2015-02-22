<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Article;
use AppBundle\Entity\Tag;
use AppBundle\Form\ArticleType;
use AppBundle\Form\CommentType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use AppBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ArticleController extends Controller {
	
	/**
	 * @Route("/admin/article/create", name="create_article")
	 */	
	public function createAction(Request $request) {
			
		$item=new Article();
		$item->setArticlePublished(false);
		$item->setArticleCreationDate(new \DateTime("now"));
		
		// We are creating, so the action is 1
		return $this->form($request, $item, 1);
	}
	
	/**
	 * @Route("/admin/article/update/{item}", name="update_article")
	 */	
	public function updateAction(Request $request, Article $item) {

		// We are updating, so the action is 2
		return $this->form($request, $item, 2);
	}
	
	private function form(Request $request, $item, $action) {
	
		$form = $this->createForm(new ArticleType(), $item, 
				array(
					'yes' => $this->get('translator')->trans('action.yes'),
					'no' => $this->get('translator')->trans('action.no')
				)
		);
	
		$form->handleRequest($request);
	
		if($form->isValid()) {
	
			$em = $this->getDoctrine()->getManager();
			$em->persist($item);
			
			try {
				// Try to persist
				$em->flush();
			
			
			} catch(\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
				return $this->render('AppBundle:form:Exception.html.twig',
					array(
					'message' => $this->get('translator')->trans('error.exception.uniqueconstraintviolation')));
			} catch(\Exception $e){
				return $this->render('AppBundle:form:Exception.html.twig',
					array(
					'message' => $this->get('translator')->trans('error.exception.generic')));
			}
				
			// If we are here is because there was no exception
			// Now we send the user to "the add tags to article" menu
			return $this->redirect($this->generateUrl('menu_add_tags_to_article', array('article' => $item->getId())));
		}
	
		return $this->render(
				'AppBundle:article:form.html.twig',
				array(
						'action' => $action,
						'form' => $form->createView()
				)
		);
	
	}
	
	/**
	 * @Route("/admin/article/delete/{item}", name="delete_article")
	 */	
	public function deleteAction(Article $item) {
	
		$em = $this->getDoctrine()->getManager();
		$em->remove($item);
		
		try {
			// Try to remove
			$em->flush();
	
		} catch(\Exception $e){
			return $this->render('AppBundle:form:Exception.html.twig',
					array(
							'message' => $this->get('translator')->trans('error.exception.generic')));
		}	
		
		// If we are here is because there was no exception
		return $this->redirect($this->generateUrl('manage_articles'));
		
	}
	
	/**
	 * @Route("/admin/article/menuaddtags/{article}", name="menu_add_tags_to_article")
	 */	
	public function menuAddTagsAction(Article $article) {
		
		$allTags=$this->getDoctrine()->getRepository('AppBundle:Tag')->findTagsNotIn($article->getTags());
		
		return $this->render(
				'AppBundle:article:menuaddtags.html.twig',
				array(
						'article' => $article,
						'allTags' => $allTags
				)
		);
		
	}
	
	/**
	 * @Route("/admin/article/addtag/{article}/{tag}", name="add_tag_to_article")
	 */	
	public function addTagAction(Article $article, Tag $tag) {
		
		$tag->addArticle($article);
		
		$em=$this->getDoctrine()->getManager();
		try {
			// Try to add this article to the tag
			$em->flush();
	
		} catch(\Exception $e){
			return $this->render('AppBundle:form:Exception.html.twig',
				array(
					'message' => $this->get('translator')->trans('error.exception.generic')));
		}	
		
		return $this->redirect($this->generateUrl('menu_add_tags_to_article', array('article' => $article->getId())));
		
	}
	
	/**
	 * @Route("/admin/article/removetag/{article}/{tag}", name="remove_tag_to_article")
	 */	
	public function removeTagAction(Article $article, Tag $tag) {
		
		$tag->removeArticle($article);
		
		$em=$this->getDoctrine()->getManager();
		try {
			// Try to remove this article to the tag
			$em->flush();
	
		} catch(\Exception $e){
			return $this->render('AppBundle:form:Exception.html.twig',
				array(
					'message' => $this->get('translator')->trans('error.exception.generic')));
		}	
		
		// If we are here is because there was no exception
		return $this->redirect($this->generateUrl('menu_add_tags_to_article', array('article' => $article->getId())));
		
	}
	
	/**
	 * @Route("/admin/article/manage/{page}/{maxResults}", name="manage_articles", defaults={"page" = 1, "maxResults" = 15})
	 */
	public function manageAction($page, $maxResults) {
		
		// Paginator sanitizer maxResults
		$maxResults=$this->get('app.utils')->paginatorCheckmaxResults($maxResults);
		// Calculate maxPages
		$maxPages=$this->getDoctrine()->getRepository('AppBundle:Article')->getMaxPages($maxResults);
		// Paginator sanitizer page
		$page=$this->get('app.utils')->paginatorCheckpage($page,$maxPages);
		// Calculate firstResult
		$firstResult=$this->get('app.utils')->paginatorGetFirstResult($page,$maxResults);
		
		$articles=$this->getDoctrine()->getRepository('AppBundle:Article')->findAllPaginatorByArticleCreationDateDESC($firstResult,$maxResults);
		return $this->render(
				'AppBundle:article:manage.html.twig',
				array(
						'items' => $articles,
						'page' => $page,
						'maxPages' => $maxPages,
						'maxResults' => $maxResults
				)
		);
	
	}
	
	/**
	 * @Route("/show/article/{article}", name="show_article")
	 */
	public function showAction(Request $request, Article $article) {
	
		$comment=new Comment();
	
		$form = $this->createForm(new CommentType(), $comment);
		$form->handleRequest($request);
	
		if($form->isValid()) {
				
			$em=$this->getDoctrine()->getManager();
				
			$comment->setCommentCreationDate(new \DateTime("now"));
			$comment->setCommentAccepted(false);
			$comment->setRelatedArticle($article);
			$article->addComment($comment);
			$em->persist($article);

			try {
				// Try to add this comment to the article
				$em->flush();
			
			} catch(\Exception $e){
				return $this->render('AppBundle:form:Exception.html.twig',
						array(
								'message' => $this->get('translator')->trans('error.exception.generic')));
			}
				
			// If we are here is because there was no exception
			return $this->redirect($this->generateUrl('show_article', array('article' => $article->getId())));
	
		}
	
		return $this->render('AppBundle:article:show.html.twig',
				array(
						'article' => $article,
						'form' => $form->createView()
				)
		);
	
	}
	
}