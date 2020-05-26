<?php

declare(strict_types=1);

namespace JustSteveKing\Graph\Builder\Clause;

use http\Exception\RuntimeException;

class WhereClause extends Clause
{
    /**
     * @var string
     */
    protected string $name = 'WHERE';

    /**
     * Create a Where Clause
     *
     * @param string $variable
     * @param string $attribute
     * @param string $operator
     * @param mixed $value
     * @param bool $or
     *
     * @return void
     */
    public function where(string $variable, string $attribute, string $operator, $value, bool $or = false) : void
    {
        $append = !empty($this->getClause());

        if ($append) {
            $this->appendAndOr($or);
        }

        if ($operator != "=") {
            throw new \RuntimeException("$operator is not supported as an operator");
        }

        $this->equals($variable, $attribute, $value);
    }

    /**
     * Add Where clause
     *
     * @param string $variable
     * @param string $attribute
     * @param mixed $value
     *
     * @return void
     */
    protected function equals(string $variable, string $attribute, $value) : void
    {
        if (gettype($value) == 'string') {
            $this->addToClause("$variable.$attribute = \"$value\"");
        } elseif (gettype($value) == 'integer' || (gettype($value) == 'double')) {
            $this->addToClause("$variable.$attribute = $value");
        } else {
            throw new \RuntimeException("Properties can not be queried using type of ".gettype($value));
        }
    }

    /**
     * Append And OR
     *
     * @param bool $appendOr
     *
     * @return void
     */
    protected function appendAndOr(bool $appendOr) : void
    {
        $stringToAppend = ($appendOr ? "OR" : "AND");
        $this->addToClause(" $stringToAppend ");
    }
}
