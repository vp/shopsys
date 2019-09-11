<?php

declare(strict_types=1);

namespace Shopsys\FrameworkBundle\Model\Security\GraphQl\Mutation;

use GraphQL\Error\UserError;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Shopsys\FrameworkBundle\Component\Domain\Domain;
use Shopsys\FrameworkBundle\Model\Customer\FrontendUserProvider;
use Shopsys\FrameworkBundle\Model\Customer\User;
use Shopsys\FrameworkBundle\Model\Security\JwtSigner;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class LoginMutation implements MutationInterface, AliasedInterface
{
    /**
     * @var \Shopsys\FrameworkBundle\Model\Customer\FrontendUserProvider
     */
    protected $frontendUserProvider;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface
     */
    protected $userPasswordEncoder;

    /**
     * @var \Shopsys\FrameworkBundle\Component\Domain\Domain
     */
    protected $domain;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Security\JwtSigner
     */
    protected $jwtSigner;

    /**
     * @param \Shopsys\FrameworkBundle\Model\Customer\FrontendUserProvider $frontendUserProvider
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $userPasswordEncoder
     * @param \Shopsys\FrameworkBundle\Component\Domain\Domain $domain
     * @param \Shopsys\FrameworkBundle\Model\Security\JwtSigner $jwtSigner
     */
    public function __construct(
        FrontendUserProvider $frontendUserProvider,
        RequestStack $requestStack,
        UserPasswordEncoderInterface $userPasswordEncoder,
        Domain $domain,
        JwtSigner $jwtSigner
    ) {
        $this->frontendUserProvider = $frontendUserProvider;
        $this->request = $requestStack->getCurrentRequest();
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->domain = $domain;
        $this->jwtSigner = $jwtSigner;
    }

    /**
     * @param \Overblog\GraphQLBundle\Definition\Argument $argument
     * @return string[]
     */
    public function login(Argument $argument): array
    {
        $input = $argument['input'];

        try {
            $user = $this->frontendUserProvider->loadUserByUsername($input['email']);
        } catch (UsernameNotFoundException $e) {
            throw new UserError('Username not found');
        }

        if (!$this->userPasswordEncoder->isPasswordValid($user, $input['password'])) {
            throw new UserError('Password is not valid');
        }

        $userToTokenData = $this->transformUserForToken($user);

        return [
            'accessToken' => $this->generateAccessToken($userToTokenData),
            'refreshToken' => $this->generateRefreshToken($userToTokenData),
        ];
    }

    /**
     * @param \Overblog\GraphQLBundle\Definition\Argument $argument
     * @return string[]
     */
    public function refreshAccessToken(Argument $argument): array
    {
        $jwtTokenString = $argument['input']['refreshToken'];

        $jwtToken = (new Parser())->parse($jwtTokenString);

        if ($jwtToken->isExpired()) {
            throw new UserError('RefreshToken is expired');
        }

        // todo: validation and verification of jwt token as is in ApiKeyAuthenticator:#L133 (should be decoupled into separate class)

        // todo: valid refresh tokens should be saved in database and here should be verification of refresh token

        $user = $this->frontendUserProvider->loadUserByUsername($jwtToken->getClaim('email'));

        $userToTokenData = $this->transformUserForToken($user);

        // todo: new refresh token is sent, the old should be invalidated

        return [
            'accessToken' => $this->generateAccessToken($userToTokenData),
            'refreshToken' => $this->generateRefreshToken($userToTokenData),
        ];
    }

    /**
     * Returns methods aliases.
     *
     * For instance:
     * array('myMethod' => 'myAlias')
     *
     * @return string[]
     */
    public static function getAliases(): array
    {
        return [
            'login' => 'user_login',
            'refreshAccessToken' => 'refresh_access_token',
        ];
    }

    /**
     * @param \Shopsys\FrameworkBundle\Model\Customer\User $user
     * @return array
     */
    protected function transformUserForToken(User $user): array
    {
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'domainId' => $user->getDomainId(),
            'roles' => $user->getRoles(),
        ];
    }

    /**
     * @todo move into separate class
     * @param array $userData
     * @return string
     */
    protected function generateAccessToken(array $userData): string
    {
        $time = time();

        $tokenBuilder = (new Builder())
            ->issuedBy($this->domain->getUrl()) // Configures the issuer (iss claim)
            ->permittedFor($this->domain->getUrl()) // Configures the audience (aud claim)
            ->issuedAt($time) // Configures the time that the token was issue (iat claim)
            ->expiresAt($time + 3600); // Configures the expiration time of the token (exp claim). 1 hour

        foreach ($userData as $key => $value) {
            $tokenBuilder = $tokenBuilder->withClaim($key, $value);
        }

        $token = $tokenBuilder->getToken($this->jwtSigner->getSigner(), $this->jwtSigner->getKey());

        return (string)$token;
    }

    /**
     * @param array $userData
     * @return string
     */
    protected function generateRefreshToken(array $userData): string
    {
        $time = time();

        $tokenBuilder = (new Builder())
            ->issuedBy($this->domain->getUrl()) // Configures the issuer (iss claim)
            ->permittedFor($this->domain->getUrl()) // Configures the audience (aud claim)
            ->issuedAt($time) // Configures the time that the token was issue (iat claim)
            ->expiresAt($time + 2592000) // Configures the expiration time of the token (exp claim). 30 days
            ->withClaim('email', $userData['email']);

        $token = $tokenBuilder->getToken($this->jwtSigner->getSigner(), $this->jwtSigner->getKey());

        return (string)$token;
    }
}
