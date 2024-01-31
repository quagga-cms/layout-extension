<?php

namespace Jackal\Extension\Layout\Abstracts;

use Jackal\Extension\Layout\Interfaces\TemplateEngineInterface;

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
