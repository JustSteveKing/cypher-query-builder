<?php

declare(strict_types=1);

namespace JustSteveKing\Graph\Builder\Clause;

class SetClause extends Clause
{
    /**
     * @var string
     */
    protected string $name = "SET";

    /**
     * @param string $variable
     * @param string $property
     * @param mixed $value
     *
     * @return void
     */
    public function set(string $variable, string $property, $value) : void
    {
        if (! empty($this->getClause())) {
            $this->addToClause(', ');
        }

        $this->addToClause($this->updateProperty($variable, $property, $value));
    }

    /**
     * @param string $variable
     * @param string $property
     * @param mixed $value
     *
     * @return string
     */
    protected function updateProperty(string $variable, string $property, $value) : string
    {
        if (gettype($value) == 'string') {
            $return = "$variable.$property = \"$value\"";
        } elseif (gettype($value) == 'integer' || gettype($value) == 'double') {
            $return = "$variable.$property = $value";
        } else {
            throw new \RuntimeException("Properties can not be set to type of ".gettype($value));
        }

        return $return;
    }

    /**
     * @param string $variable
     * @param array $properties
     * @return string
     */
    public function updateFromArray(string $variable, array $properties) : string
    {
        $return = [];
        foreach ($properties as $key => $value) {
            $return[] = $this->updateProperty($variable, $key, $value);
        }

        return implode(', ', $return);
    }

    /**
     * @param string $variable
     * @param array $properties
     *
     * @return void
     */
    public function setArray(string $variable, array $properties) : void
    {
        $this->addToClause($this->updateFromArray($variable, $properties));
    }
}
