<?php

namespace App\Facades\Actions;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string run()
 */
class GenerateEnrollment extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \App\Actions\GenerateEnrollment::class;
    }
}
