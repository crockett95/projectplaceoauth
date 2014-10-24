<?php

namespace Crockett95\ProjectPlace;

use OAuth\OAuth1\Signature\SignatureInterface;
use OAuth\OAuth1\Token\StdOAuth1Token;
use OAuth\Common\Http\Exception\TokenResponseException;
use OAuth\Common\Http\Uri\Uri;
use OAuth\Common\Consumer\CredentialsInterface;
use OAuth\Common\Http\Uri\UriInterface;
use OAuth\Common\Storage\TokenStorageInterface;
use OAuth\Common\Http\Client\ClientInterface;
use OAuth\Common\Exception\Exception;
use OAuth\OAuth1\Service\AbstractService;

class OAuthService extends AbstractService
{
    const ENDPOINT_AUTHORIZE = "https://api.projectplace.com/authorize";
    const SERVICE_NAME = 'ProjectPlace';

    protected $authorizationEndpoint = self::ENDPOINT_AUTHORIZE;

    public function service()
    {
        return self::SERVICE_NAME;
    }

    public function __construct(
        CredentialsInterface $credentials,
        ClientInterface $httpClient,
        TokenStorageInterface $storage,
        SignatureInterface $signature,
        UriInterface $baseApiUri = null
    ) {
        parent::__construct($credentials, $httpClient, $storage, $signature, $baseApiUri);

        if (null === $baseApiUri) {
            $this->baseApiUri = new Uri('https://api.projectplace.com/1/');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestTokenEndpoint()
    {
        return new Uri('https://api.projectplace.com/initiate');
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorizationEndpoint()
    {
        if ($this->authorizationEndpoint != self::ENDPOINT_AUTHORIZE) {
            $this->authorizationEndpoint = self::ENDPOINT_AUTHORIZE;
        }
        return new Uri($this->authorizationEndpoint);
    }

    /**
     * {@inheritdoc}
     */
    public function getAccessTokenEndpoint()
    {
        return new Uri('https://api.projectplace.com/token');
    }

    /**
     * {@inheritdoc}
     */
    protected function parseRequestTokenResponse($responseBody)
    {
        error_log(var_export($responseBody, true));
        parse_str($responseBody, $data);

        if (null === $data || !is_array($data)) {
            throw new TokenResponseException('Unable to parse response.');
        } elseif (!isset($data['oauth_callback_confirmed']) || $data['oauth_callback_confirmed'] !== 'true') {
            throw new TokenResponseException('Error in retrieving token.');
        }

        return $this->parseAccessTokenResponse($responseBody);
    }

    /**
     * {@inheritdoc}
     */
    protected function parseAccessTokenResponse($responseBody)
    {
        error_log(var_export($responseBody, true));
        parse_str($responseBody, $data);

        if (null === $data || !is_array($data)) {
            throw new TokenResponseException('Unable to parse response.');
        } elseif (isset($data['error'])) {
            throw new TokenResponseException('Error in retrieving token: "' . $data['error'] . '"');
        }

        $token = new StdOAuth1Token();

        $token->setRequestToken($data['oauth_token']);
        $token->setRequestTokenSecret($data['oauth_token_secret']);
        $token->setAccessToken($data['oauth_token']);
        $token->setAccessTokenSecret($data['oauth_token_secret']);

        $token->setEndOfLife(StdOAuth1Token::EOL_NEVER_EXPIRES);
        unset($data['oauth_token'], $data['oauth_token_secret']);
        $token->setExtraParams($data);

        return $token;
    }
}
