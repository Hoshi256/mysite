<?php 

namespace App\Security;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Psr\Log\NullLogger;
use Twig\Cache\NullCache;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class GithubAuthenticator extends SocialAuthenticator 
{
    private RouterInterface $router;

    private ClientRegistry $clientRegistry;

    public function __construct (RouterInterface $router, ClientRegistry $clientRegistry) {
        $this->router = $router;
        $this->clientRegistry = $clientRegistry;

    }

   public function start(Request $request, AuthenticationException $authException = null)
   {
    return new RedirectResponse($this->router->generate('app_login'));
   }

   public function supports(Request $request)
   {
       return 'oauth_check'=== $request->attributes->get('_route') && $request->get('service') === 'github';
   }

   public function getCredential(Request $request)
   {
    return $this->fetchAccessToken($this->clientRegistry->getClient('github'));
   }

   public function getUser($credentials, UserProviderInterface $userProvider)
   {
    dd($credentials);
   }
}
