<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LoginController extends Controller {
	
	/**
	 * @Route("/login", name="login")
	 */
	public function loginAction(Request $request) {
	
		$session = $request->getSession();
	
		// get the login error if there is one
		if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
			$error = $request->attributes->get(
					SecurityContext::AUTHENTICATION_ERROR
			);
		} else {
			$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
			$session->remove(SecurityContext::AUTHENTICATION_ERROR);
		}
	
		return $this->render(
				'AppBundle:login:login.html.twig',
				array(
						// last username entered by the user
						'last_username' => $session->get(SecurityContext::LAST_USERNAME),
						'error'         => $error,
				)
		);
	}
	
	/**
	 * @Route("/login_check", name="login_check")
	 */
	public function loginCheckAction() {
	}
	
	/**
	 * @Route("/logout", name="logout")
	 */
	public function logoutAction() {
	}
	
}
