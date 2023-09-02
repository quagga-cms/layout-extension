<?php

namespace PuleenoCMS\Layout;

use App\Core\Application;
use DI\Container;
use PuleenoCMS\Exceptions\ContainerException;
use PuleenoCMS\Layout\Abstracts\TemplateEngine;
use PuleenoCMS\Layout\Engines\Twig;
use Slim\Views\TwigMiddleware;

final class TemplateManager
{
    protected Twig $twig;

    protected static Application $app;

    private static $instance;

    private function __construct(Application &$app)
    {
        self::$app = $app;
    }

    public static function getInstance(Application &$app)
    {
        if (is_null(static::$instance)) {
            static::$instance = new self($app);
        }
        return static::$instance;
    }

    public function createView()
    {
        $layoutViewDirectory = sprintf(
            str_replace('/', DIRECTORY_SEPARATOR, '%s/resources/views'),
            dirname(__DIR__)
        );

        $twigSettings = [];
        if (!boolval(getenv('VIEW_DEBUG'))) {
            $twigSettings['cache'] = getPath('cache') . DIRECTORY_SEPARATOR . 'views';
        }
        $this->twig = Twig::create([$layoutViewDirectory], $twigSettings);

        // Set view in Container
        /**
         * @var \DI\Container
         */
        $container = static::$app->getContainer();
        $container->set('view', $this->twig);
    }

    public static function getView(): ?TemplateEngine
    {
        if (is_null(static::$instance)) {
            throw new ContainerException();
        }
        return static::$app->getContainer()->get('view');
    }
}
