<?php
namespace App\Contracts;

interface Processable
{
    public static function getUnprocessedModelsWhereBeganAtIsNull();

    public static function getUnprocessedModelsWhereFinishedAtIsNull();
}
