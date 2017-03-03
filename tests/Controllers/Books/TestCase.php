<?php

namespace Tests\Controllers\Books;

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
            [null, null, ['title', 'author']],
            ['The Jedi Path', 99, ['author']],
        ];
    }
}
