<?php

namespace PuleenoCMS\Layout;

use App\Core\Extension;
use App\Core\HookManager;
use PuleenoCMS\Layout\Middlewares\TwigMiddleware;

class LayoutExtension extends Extension
{
    public function isBuiltIn(): bool
    {
        return true;
    }

    public function bootstrap()
    {
        $templateManager = TemplateManager::getInstance($this->app);
        HookManager::addAction(
            'loaded_extensions',
            [$templateManager, 'createView']
        );
    }

    public function run()
    {
        // Add Twig-View Middleware
        $this->app->add(TwigMiddleware::createFromContainer($this->app));
    }
}
