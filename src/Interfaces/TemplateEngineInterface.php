<?php

namespace PuleenoCMS\Layout\Interfaces;

use ArrayAccess;
use Psr\Http\Message\ResponseInterface;

interface TemplateEngineInterface extends ArrayAccess
{
    public function setPaths($paths): self;
    public function addPath($paths): self;

    public function render(ResponseInterface $response, string $template, array $data = []): ResponseInterface;

    public function getAllowedExtensions(): ?array;

    public function getDefaultExtension(): string;

    public function registerFunction($functionName, $callable);
}
