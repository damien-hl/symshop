<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class LoginFormAuthenticator extends AbstractGuardAuthenticator
{
    protected UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request): bool
    {
        return $request->attributes->get('_route') === 'security_login'
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        return $request->request->get('login');
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        try {
            return $userProvider->loadUserByUsername($credentials['email']);
        } catch (UsernameNotFoundException $exception) {
            throw new AuthenticationException("Cette adresse email n'est pas connue");
        }
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        $isValid = $this->encoder->isPasswordValid($user, $credentials['password']);

        if (!$isValid) {
            throw new AuthenticationException("Les informations de connexion ne correspondent pas");
        }

        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $request->attributes->set(Security::AUTHENTICATION_ERROR, $exception);
        $request->attributes->set(Security::LAST_USERNAME, ($request->request->get('login')['email']));

        return null;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey): ?Response
    {
        return new RedirectResponse('/');
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new RedirectResponse('/login');
    }

    public function supportsRememberMe(): bool
    {
        // todo
    }
}
