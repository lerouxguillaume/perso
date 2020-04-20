<?php

namespace App\Security;

use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Trikoder\Bundle\OAuth2Bundle\Security\Authentication\Token\OAuth2Token;
use Trikoder\Bundle\OAuth2Bundle\Security\Authentication\Token\OAuth2TokenFactory;
use Trikoder\Bundle\OAuth2Bundle\Security\Exception\Oauth2AuthenticationFailedException;

class AuthenticateUrlProvider
{
    /** @var TokenStorageInterface */
    private $tokenStorage;

    /** @var AuthenticationManagerInterface */
    private $authenticationManager;

    /** @var HttpMessageFactoryInterface  */
    private $httpMessageFactory;

    /** @var OAuth2TokenFactory  */
    private $oauth2TokenFactory;

    /** @var string  */
    private $providerKey = 'main';

    /**
     * AuthenticateUrlProvider constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param AuthenticationManagerInterface $authenticationManager
     * @param HttpMessageFactoryInterface $httpMessageFactory
     * @param OAuth2TokenFactory $oauth2TokenFactory
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        AuthenticationManagerInterface $authenticationManager,
        HttpMessageFactoryInterface $httpMessageFactory,
        OAuth2TokenFactory $oauth2TokenFactory
    ){
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
        $this->httpMessageFactory = $httpMessageFactory;
        $this->oauth2TokenFactory = $oauth2TokenFactory;
    }

    public function authenticateUser(Request $request)
    {
        if (empty($accessToken = $request->get('access_token'))) {
            return;
        }

        $request = $this->httpMessageFactory->createRequest($request);

        $request = $request->withAddedHeader('Authorization', $accessToken);

        if (!$request->hasHeader('Authorization')) {
            return;
        }

        try {
            /** @var OAuth2Token $authenticatedToken */
            $authenticatedToken = $this->authenticationManager->authenticate($this->oauth2TokenFactory->createOAuth2Token($request, null, $this->providerKey));
        } catch (AuthenticationException $e) {
            throw Oauth2AuthenticationFailedException::create($e->getMessage());
        }

        $this->tokenStorage->setToken($authenticatedToken);
    }
}