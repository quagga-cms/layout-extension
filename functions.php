<?php

use App\Common\Option;
use App\Core\Application;
use App\Core\Env;
use Psr\Http\Message\ResponseInterface;
use PuleenoCMS\Layout\TemplateManager;

/**
 * Undocumented function
 *
 * @param string|array $templateName The template file name
 * @param array $data The data list will be shared to view. The data key as a variable name in the view
 * @param string $viewType The type of view. Support 3 types such as: core, theme, extension
 *
 * @return Psr\Http\Message\ResponseInterface
 */
function view($templateName, $data = [], ResponseInterface $response = null, $viewType = null): ResponseInterface
{
    if (!in_array($viewType, ['ext', 'theme'])) {
        $viewType = 'core';
    }
    if (is_null($response)) {
        $app = Application::getInstance();
        $container = $app->getContainer();
        $response = $container->get('response');
    }

    $templateEngine = TemplateManager::getView();

    return $templateEngine->render($response, $templateName, $data);
}

function extensionView($extName, $templateName, $data = [], ResponseInterface $response = null): ResponseInterface
{
    $templateEngine = TemplateManager::getView();
    $directoryTempl = str_replace('/', DIRECTORY_SEPARATOR, '%s/%s/resources/views');
    $viewDirectory  = sprintf($directoryTempl, get_path('extension'), $extName);

    $templateEngine->addPath($viewDirectory);

    return view($templateName, $data, $response, 'ext');
}

function getThemeViewDirectory()
{
    $activeTheme    = get_active_theme();
    $directoryTempl = str_replace('/', DIRECTORY_SEPARATOR, '%s/%s/views');

    return sprintf(
        $directoryTempl,
        get_path('theme'),
        $activeTheme
    );
}

function themeView($templateName, $data = [], ResponseInterface $response = null): ResponseInterface
{
    return view($templateName, $data, $response, 'theme');
}
