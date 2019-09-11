<?php

declare(strict_types=1);

namespace Shopsys\FrameworkBundle\Model\Security;

use InvalidArgumentException;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;
use Shopsys\FrameworkBundle\Component\Domain\Domain;
use Shopsys\FrameworkBundle\Model\Customer\FrontendUserProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;

class ApiKeyAuthenticator implements SimplePreAuthenticatorInterface, AuthenticationFailureHandlerInterface
{
    /**
     * @var \Shopsys\FrameworkBundle\Component\Domain\Domain
     */
    protected $domain;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Security\JwtSigner
     */
    protected $jwtSigner;

    /**
     * @param \Shopsys\FrameworkBundle\Component\Domain\Domain $domain
     * @param \Shopsys\FrameworkBundle\Model\Security\JwtSigner $jwtSigner
     */
    public function __construct(Domain $domain, JwtSigner $jwtSigner)
    {
        $this->domain = $domain;
        $this->jwtSigner = $jwtSigner;
    }

    /**
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     * @param \Symfony\Component\Security\Core\User\UserProviderInterface $userProvider
     * @param string $providerKey
     * @return \Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey): PreAuthenticatedToken
    {
        if (!$userProvider instanceof FrontendUserProvider) {
            throw new InvalidArgumentException(
                sprintf(
                    'The user provider must be an instance of ApiKeyUserProvider (%s was given).',
                    get_class($userProvider)
                )
            );
        }

        $jwtToken = $this->getJwtToken($token->getCredentials());

        $this->validateToken($jwtToken);

        $user = $userProvider->loadUserByUsername($jwtToken->getClaim('email'));

        return new PreAuthenticatedToken(
            $user,
            (string)$jwtToken,
            $providerKey,
            $user->getRoles()
        );
    }

    /**
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     * @param string $providerKey
     * @return bool
     */
    public function supportsToken(TokenInterface $token, $providerKey): bool
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $providerKey
     * @return \Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken|null
     */
    public function createToken(Request $request, $providerKey): ?PreAuthenticatedToken
    {
        // todo: not on login and refreshToken mutation

        $apiKey = $request->headers->get('authorization');
        $apiKey = preg_replace('~^bearer\s+~i', '', $apiKey);

        if (!$apiKey) {
            return null;
        }

        return new PreAuthenticatedToken(
            'anon.',
            $apiKey,
            $providerKey
        );
    }

    /**
     * @param string $jwtTokenString
     * @return \Lcobucci\JWT\Token
     */
    protected function getJwtToken(string $jwtTokenString): Token
    {
        return (new Parser())->parse($jwtTokenString);
    }

    /**
     * @param \Lcobucci\JWT\Token $token
     */
    protected function validateToken(Token $token): void
    {
        $validationData = new ValidationData();
        $validationData->setAudience($this->domain->getUrl());
        $validationData->setIssuer($this->domain->getUrl());

        if ($token->isExpired()) {
            throw new CustomUserMessageAuthenticationException('API Key is expired. Please renew.');
        }

        if (!$token->validate($validationData)) {
            throw new CustomUserMessageAuthenticationException('API Key is not valid.');
        }

        if (!$token->verify($this->jwtSigner->getSigner(), $this->jwtSigner->getKey())) {
            throw new CustomUserMessageAuthenticationException('API Key could not be verified');
        }
    }

    /**
     * This is called when an interactive authentication attempt fails. This is
     * called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\Exception\AuthenticationException $exception
     * @return \Symfony\Component\HttpFoundation\Response The response to return, never null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        $responseData = [
            'error' => $exception->getMessage(),
        ];

        return new JsonResponse($responseData, 401);
    }
}
