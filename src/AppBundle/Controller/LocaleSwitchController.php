<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LocaleSwitchController extends Controller {

	/**
	 * @Route("/switchenglish", name="switch_language_english")
	 */
	public function swithLanguageEnglishAction() {
		return $this->swithLanguage('en');
	}
	
	/**
	 * @Route("/switchspanish", name="switch_language_spanish")
	 */	
	public function swithLanguageSpanishAction() {
		return $this->swithLanguage('es');
	}
	
	private function swithLanguage($locale) {
		$this->get('session')->set('_locale', $locale);
		return $this->redirect($this->generateUrl('homepage'));
	}
	
}