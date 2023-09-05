<?php

namespace PuleenoCMS\Layout;

use App\Common\Option;
use App\Core\Application;
use App\Core\HookManager;
use PuleenoCMS\Exceptions\ContainerException;
use PuleenoCMS\Layout\Abstracts\TemplateEngine;
use PuleenoCMS\Layout\Engines\Twig;
use PuleenoCMS\Layout\Middlewares\TwigMiddleware;

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

    protected function registerFunctions()
    {
        $this->twig->registerFunction('do_action', [HookManager::class, 'executeAction']);
        $this->twig->registerFunction('apply_filters', [HookManager::class, 'applyFilters']);
        $this->twig->registerFunction('get_option', [Option::class, 'getOption']);
    }

    public function createView()
    {
        $layoutViewDirectory = sprintf(
            str_replace('/', DIRECTORY_SEPARATOR, '%s/resources/views'),
            dirname(__DIR__)
        );

        $twigSettings = [];
        if (!boolval(getenv('VIEW_DEBUG'))) {
            $twigSettings['cache'] = get_path('cache') . DIRECTORY_SEPARATOR . 'views';
            $twigSettings['debug'] = true;
        }
        $this->twig = Twig::create([$layoutViewDirectory], $twigSettings);

        $this->registerFunctions();

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

    public function loadMiddlewares()
    {
        self::$app->add(TwigMiddleware::createFromContainer(self::$app));
    }
}
