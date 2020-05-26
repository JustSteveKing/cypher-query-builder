<?php

declare(strict_types=1);

namespace JustSteveKing\Graph\Builder\Clause;

class CreateClause extends Clause
{
    /**
     * @var string
     */
    protected string $name = 'CREATE';

    public function create(string $variable, string $label, array $properties = []) : void
    {
        if (! empty($this->getClause())) {
            $this->addToClause(', ');
        }

        if (! empty($properties)) {
            $this->addToClause("($variable:$label " . $this->createFromArray($properties) . ")");
        } else {
            $this->addToClause("($variable:$label)");
        }
    }

    protected function createFromArray(array $properties) : string
    {
        $return = [];

        foreach ($properties as $key => $value) {
            switch(gettype($value)) {
                case 'string':
                    $return[] = "$key: \"$value\"";
                    break;
                case 'integer':
                case 'double':
                    $return[] = "$key: $value";
                    break;
                default:
                    throw new \RuntimeException("Properties can not be set to type of ".gettype($value));
            }
        }

        return '{ ' . implode(', ', $return) .' }';
    }
}
