<?php

namespace Tests\Books;

use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Provides an array of invalid field values
     * for testing request validations.
     *
     * @return array
     */
    public function invalidFieldsValuesProvider()
    {
        return [
            [null, null],
            ['The Jedi Path', 99],
        ];
    }
}
