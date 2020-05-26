<?php

declare(strict_types=1);

namespace JustSteveKing\Graph\Builder\Clause;

class ReturnClause extends Clause
{
    /**
     * @var string
     */
    protected string $name = 'RETURN';

    /**
     * Create a return statement for the query
     *
     * @param string $variable
     * @param string $attribute
     *
     * @return void
     */
    public function return(string $variable, string $attribute = '') : void
    {
        $append = ! empty($this->getClause());

        if ($append) {
            $this->addToClause(', ');
        }

        if (empty($attribute)) {
            $this->addToClause($variable);
        } else {
            $this->addToClause($variable . '.' . $attribute);
        }
    }
}
