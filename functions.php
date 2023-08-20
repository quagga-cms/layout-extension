<?php

/**
 * Undocumented function
 *
 * @param string|array $templateName The template file name
 * @param array $data The data list will be shared to view. The data key as a variable name in the view
 * @param string $viewType The type of view. Support 3 types such as: core, theme, extension
 *
 * @return void
 */
function view($templateName, $data = [], $viewType = null)
{
    if (!in_array($viewType, ['ext', 'theme'])) {
        $viewType = 'core';
    }
}

function extensionView($templateName, $data = [])
{
    return view($templateName, $data, 'ext');
}

function themeView($templateName, $data = [])
{
    return view($templateName, $data, 'theme');
}
