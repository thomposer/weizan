<?php
function getCode()
{
}
function M($name)
{
    include IA_ROOT . '/addons/imeepos_runner/inc/model/' . $name . '.mod.php';
    $model = 'imeepos_runner_' . $name;
    return new $model();
}