<?php

declare(strict_types=1);

namespace JustSteveKing\Graph\Builder\Clause;

class DeleteClause extends Clause
{
    /**
     * @var string
     */
    protected string $name = 'DELETE';

    /**
     * Create a Delete Clause
     *
     * @param string $variable
     *
     * @return void
     */
    public function delete(string $variable) : void
    {
        if (! empty($this->getClause())) {
            $this->addToClause(', ');
        }

        $this->addToClause("$variable");
    }
}
