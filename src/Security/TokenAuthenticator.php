<?php

namespace App\Security;

use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class TokenAuthenticator extends AbstractGuardAuthenticator {

	public function start(Request $request, AuthenticationException $authException = null) {

		return new JsonResponse(null, Response::HTTP_UNAUTHORIZED);
	}

	public function supports(Request $request) {

		return $request->headers->has('X-Auth-Token');
	}

	public function getCredentials(Request $request) {

		$token = $request->headers->get('X-Auth-Token');

		return $token;
	}

	public function getUser($credentials, UserProviderInterface $userProvider) {

		// return new User('username', 'password');
		return $userProvider->loadUserByUsername($credentials);
	}

	public function checkCredentials($credentials, UserInterface $user) {

		return true;
	}

	public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {

		return new JsonResponse(null, Response::HTTP_FORBIDDEN);
	}

	public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey) {

		return null;
	}

	public function supportsRememberMe() {

		return false;
	}
}	