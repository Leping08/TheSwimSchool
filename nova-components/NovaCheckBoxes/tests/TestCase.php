<?php

namespace Fourstacks\NovaCheckboxes\Tests;

use Laravel\Nova\Fields\Field;
use Orchestra\Testbench\TestCase as BaseTest;
use PHPUnit\Framework\Assert;

class TestCase extends BaseTest
{
    protected function setUp()
    {
        parent::setUp();

        $this->registerTestingMacros();
    }

    /**
     * Register extra testing macros.
     */
    protected function registerTestingMacros()
    {
        Field::macro('assertValue', function ($expected, $actual, $attribute = null) {
            $this->resolve((object) [$this->attribute => $actual], $attribute ?? $this->attribute);
            Assert::assertEquals($expected, $this->value);

            $this->resolveForDisplay((object) [$this->attribute => $actual], $attribute ?? $this->attribute);
            Assert::assertEquals($expected, $this->value);

            return $this;
        });
    }

    /**
     * Get the service providers for the package.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            'Fourstacks\NovaCheckboxes\FieldServiceProvider',
        ];
    }
}
