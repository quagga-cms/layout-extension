<?php

namespace Jackal\Extension\Layout;

use Jackal\Jackal\Extension;
use Jackal\Jackal\HookManager;

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

        HookManager::addAction(
            'loaded_extensions',
            [$templateManager, 'loadMiddlewares'],
            99
        );
    }

    public function run()
    {
    }
}
