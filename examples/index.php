<?php

/**
 * Example of retrieving an authentication token of the ProjectPlace service
 *
 * PHP version 5.4
 *
 * @author     David Desberg <david@daviddesberg.com>
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2012 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 *
 * Modified 2014 Steve Crockett
 */

use Crockett95\ProjectPlace\OAuthService;
use OAuth\Common\Storage\Session;
use OAuth\Common\Consumer\Credentials;

/**
 * Bootstrap the library
 */
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Setup error reporting
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Setup the timezone
 */
ini_set('date.timezone', 'Europe/Amsterdam');

/**
 * Create a new instance of the URI class with the current URI, stripping the query string
 */
$uriFactory = new \OAuth\Common\Http\Uri\UriFactory();
$currentUri = $uriFactory->createFromSuperGlobalArray($_SERVER);
$currentUri->setQuery('');
$serviceFactory = new \OAuth\ServiceFactory();
$serviceFactory->registerService('projectplace', 'Crockett95\\ProjectPlace\\OAuthService');

/**
 * Load the credential for the different services
 */
$serviceCredentials = require_once __DIR__ . '/keys.php';

// We need to use a persistent storage to save the token, because oauth1 requires the token secret received before'
// the redirect (request token request) in the access token request.
$storage = new Session();

// Setup the credentials for the requests
$credentials = new Credentials(
    $serviceCredentials['key'],
    $serviceCredentials['secret'],
    $currentUri->getAbsoluteUri()
);

// Instantiate the twitter service using the credentials, http client and storage mechanism for the token
/** @var $twitterService Twitter */
$projectPlaceService = $serviceFactory->createService('projectplace', $credentials, $storage);

if (!empty($_GET['oauth_token'])) {
    $token = $storage->retrieveAccessToken('ProjectPlace');

    // This was a callback request from twitter, get the token
    $projectPlaceService->requestAccessToken(
        $_GET['oauth_token'],
        $_GET['oauth_verifier'],
        $token->getRequestTokenSecret()
    );

    // Send a request now that we have access token
    $result = json_decode($projectPlaceService->request('/user/me/projects.json'));

    echo 'result: <pre>' . print_r($result, true) . '</pre>';

} elseif (!empty($_GET['go']) && $_GET['go'] === 'go') {
    // extra request needed for oauth1 to request a request token :-)
    $token = $projectPlaceService->requestRequestToken();

    $url = $projectPlaceService->getAuthorizationUri(array('oauth_token' => $token->getRequestToken()));
    header('Location: ' . $url);
} else {
    $url = $currentUri->getRelativeUri() . '?go=go';
    echo "<a href='$url'>Login with ProjectPlace!</a>";
}
