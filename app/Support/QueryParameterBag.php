<?php

namespace App\Support;

use Illuminate\Http\Request;

class QueryParameterBag
{
    /**
     * HTTP request handler.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Creates a new class instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Check if a parameter exists within the request.
     *
     * @param  string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return $this->request->has($name);
    }

    /**
     * Get all query parameters.
     *
     * @return array
     */
    public function all()
    {
        return $this->request->query();
    }

    /**
     * Is triggered when invoking inaccessible methods in the parameter bag.
     *
     * @param  string $name
     * @param  array  $arguments
     *
     * @return mixed
     */
    public function __call($name, array $arguments = [])
    {
        $name = snake_case($name);
        $default = ($arguments) ? $arguments[0] : null;

        $value = $this->request->query($name, $default);

        if (is_numeric($value)) {
            return intval($value);
        }

        return $value;
    }
}
