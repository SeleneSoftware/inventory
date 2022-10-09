<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AppOauthAuthenticator extends OAuth2Authenticator implements AuthenticationEntrypointInterface
{
    use ArrayAccessorTrait;
    private $clientRegistry;
    private $entityManager;
    private $router;
    private $params;
    private $client;

    public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $entityManager, RouterInterface $router, ContainerBagInterface $params, HttpClientInterface $client)
    {
        $this->clientRegistry = $clientRegistry;
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->params = $params;
        $this->client = $client;
    }

    public function supports(Request $request): ?bool
    {
        // continue ONLY if the current ROUTE matches the check ROUTE
        return 'connect_github_check' === $request->attributes->get('_route');
    }

    public function authenticate(Request $request): Passport
    {
        $client = $this->clientRegistry->getClient('github');
        $accessToken = $this->fetchAccessToken($client);

        return new SelfValidatingPassport(
            new UserBadge($accessToken->getToken(), function () use ($accessToken, $client) {
                $githubUser = $client->fetchUserFromToken($accessToken);

                $email = $githubUser->getEmail();

                // 1) have they logged in with Github before? Easy!
                $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['githubId' => $githubUser->getId()]);

                if ($existingUser) {
                    return $existingUser;
                }

                // 2) do we have a matching user by email?
                $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
                if ($existingUser) {
                    return $existingUser;
                }

                // 3) Now save them to the database so we can just use them again
                $user = new User();

                $orgURL = $this->getValueByKey($githubUser->toArray(), 'organizations_url');

                $response = $this->client->request(
                    'GET',
                    $orgURL
                );

                if (200 != $response->getStatusCode()) {
                    return false;
                }
                $orgArray = json_decode($response->getContent(), true);
                if (!count($orgArray)) {
                    return false;
                }
                foreach ($orgArray as $org) {
                    if ('SeleneSoftware' === $this->getValueByKey($orgArray[0], 'login')) {
                        $user->setGithubId($githubUser->getId())
                            ->setEmail($githubUser->getEmail())
                        ;
                        $this->entityManager->persist($user);
                        $this->entityManager->flush();

                        return $user;
                    }
                }

                return false;
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->router->generate('admin'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($message, Response::HTTP_FORBIDDEN);
    }

    /**
     * Called when authentication is needed, but it's not sent.
     * This redirects to the 'login'.
     */
    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new RedirectResponse(
            '/connect/github/', // might be the site, where users choose their oauth provider
            Response::HTTP_TEMPORARY_REDIRECT
        );
    }
}
