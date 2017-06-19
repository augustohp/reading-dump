<?php
/**
 * This will help users to generate their access token with Pocket app.
 */

// Configuration of the environment
ini_set('display_errors', true);
error_reporting(-1);
require __DIR__ . '/../vendor/autoload.php';
define('HTTP_PROTOCOL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https' : 'http');
define('APP_URL', HTTP_PROTOCOL . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
define('APP_CONSUMER_KEY', getenv('POCKET_APP_CONSUMER_KEY') ?: '');
if (empty(APP_CONSUMER_KEY)) {
    throw new \UnexpectedValueException(
        '"POCKET_APP_CONSUMER_KEY" environment variable empty.'
    );
}

// Shitty reusable components
function checkRequiredTemplateVariables(
    array $requiredVariableNames,
    array $declaredVariables,
    $templateFile
) {
    foreach ($requiredVariableNames as $variableName) {
        $variableDeclared = isset($declaredVariables[$variableName]);
        if ($variableDeclared) {
            continue;
        }

        throw new \UnexpectedValueException(
            sprintf(
                'Expected variable "%s" for template "%s".',
                $variableName,
                basename($templateFile)
            )
        );
    }
}

function renderTemplate($name, array $templateVariables)
{
    $layoutFile = __DIR__ . '/layout.php';
    $template = __DIR__ . '/' . $name . '.template.php';
    if (false === file_exists($template)) {
        throw new \UnexpectedValueException(
            sprintf(
                'Template "%s" not found.',
                $template
            )
        );
    }
    foreach ($templateVariables as $name=>$value) {
        $$name = $value;
    }

    return require $layoutFile;
}

// The application
$pocketApi = new Pocket([
    'consumerKey' => APP_CONSUMER_KEY
]);
$requestToken = filter_input(INPUT_GET, 'requestToken', FILTER_SANITIZE_STRING);
$userNeedsToAuthorizeApp = (empty($requestToken));
if ($userNeedsToAuthorizeApp) {
    $queryStringParameterWithRequestToken = '?requestToken=';
    $urlToRedirectUserAfterGrantingAccess = APP_URL .$queryStringParameterWithRequestToken;
    $requestObject = $pocketApi->requestToken($urlToRedirectUserAfterGrantingAccess);
    $requestUrl = str_replace(
        urlencode($queryStringParameterWithRequestToken),
        urlencode($queryStringParameterWithRequestToken . $requestObject['request_token']),
        $requestObject['redirect_uri']
    );
    return renderTemplate(
        'request_token',
        compact('requestUrl')
    );
}

$userObject = $pocketApi->convertToken($requestToken);
$accessToken = $userObject['access_token'];
$userName = $userObject['username'];
return require __DIR__ . '/print_token.template.php';
