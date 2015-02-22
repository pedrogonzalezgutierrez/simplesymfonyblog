<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Article;
use AppBundle\Search\SearchByTitle;
use AppBundle\Search\SearchByTitleType;


class HomePageController extends Controller {
	
	/**
	 * @Route("/", name="homepage")
	 */
	public function homepageAction() {		
		
		// firstResult=0 ; maxResults=Article::MAXIMUM_ARTICLES_IN_HOMEPAGE ; articlePublished = true
		$articles=$this->getDoctrine()->getRepository('AppBundle:Article')->findAllPaginatorByArticleCreationDateDESCAndArticlePublished(0,Article::MAXIMUM_ARTICLES_IN_HOMEPAGE,true);
		
		return $this->render('AppBundle:homepage:homepage.html.twig', array('articles' => $articles));		 
				 
	}
	
	/**
	 * @Route("/readmore/{page}/{maxResults}", name="readmore", defaults={"page" = 1, "maxResults" = 5})
	 */
	public function readMoreAction($page, $maxResults) {
		
		// Paginator sanitizer maxResults
		$maxResults=$this->get('app.utils')->paginatorCheckmaxResults($maxResults);
		// Calculate maxPages
		$maxPages=$this->getDoctrine()->getRepository('AppBundle:Article')->getMaxPagesArticlesPublished($maxResults);
		// Paginator sanitizer page
		$page=$this->get('app.utils')->paginatorCheckpage($page,$maxPages);
		// Calculate firstResult
		$firstResult=$this->get('app.utils')->paginatorGetFirstResult($page,$maxResults);
	
		$articles=$this->getDoctrine()->getRepository('AppBundle:Article')->findAllPaginatorByArticleCreationDateDESCAndArticlePublished($firstResult,$maxResults,true);
		return $this->render(
				'AppBundle:homepage:readmore.html.twig',
				array(
						'articles' => $articles,
						'page' => $page,
						'maxPages' => $maxPages,
						'maxResults' => $maxResults
				)
		);
	
	}
	
	/**
	 * @Route("/search", name="search")
	 */
	public function searchAction(Request $request) {
		
		$tags=$this->getDoctrine()->getRepository('AppBundle:Tag')->findAllByTagNameASC();
		
		$searchByTitle=new SearchByTitle();
		
		$formSearchByTitle = $this->createForm(new SearchByTitleType(), $searchByTitle);
		$formSearchByTitle->handleRequest($request);
		
		if($formSearchByTitle->isValid()) {

			$articles=$this->getDoctrine()->getRepository('AppBundle:Article')->findAllByArticleCreationDateDESCAndArticlePublishedAndArticleTitle(true, $searchByTitle->getTitle());
			
			if( count($articles) == 0 ) {
				return $this->render('AppBundle:search:search-noresults.html.twig');
			}
		
			return $this->render('AppBundle:search:search-results.html.twig', array('articles' => $articles));	
		
		}
		
		return $this->render('AppBundle:search:search.html.twig',
				array(
						'formSearchByTitle' => $formSearchByTitle->createView(),
						'tags' => $tags
				)
		);
	}
		
	/**
	 * @Route("/about", name="about")
	 */
	public function aboutAction() {
		return $this->render('AppBundle:about:about.html.twig');
	}
	
}