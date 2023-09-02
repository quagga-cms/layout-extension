<?php

namespace PuleenoCMS\Layout\Abstracts;

use PuleenoCMS\Layout\Interfaces\TemplateEngineInterface;

abstract class TemplateEngine implements TemplateEngineInterface
{
    public function getAllowExtensions(): ?array
    {
        return null;
    }

    public function getDefaultExtension(): string
    {
        return 'html';
    }
}
