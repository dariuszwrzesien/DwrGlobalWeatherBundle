<?php

namespace Dwr\OpenWeatherBundle\Factory;

use LogicException;

class ResponseFactory
{
    const RESPONSE_SERVICE = 'Dwr\\OpenWeatherBundle\\Entity\\';

    /**
     * @var string
     */
    private $type;

    /**
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create($data)
    {
        if (empty($this->type)) {
            throw new LogicException('Parameter $type has to be set before call create() function.');
        }

        $response = self::RESPONSE_SERVICE . $this->type;
        return new $response(json_decode($data, true));
    }
}