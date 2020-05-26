<?php

declare(strict_types=1);

namespace JustSteveKing\Graph\Builder\Clause;

class RemoveClause extends Clause
{
    /**
     * @var string
     */
    protected string $name = 'REMOVE';

    public function remove(string $variable, string $label) : void
    {
        if (! empty($this->getClause())) {
            $this->addToClause(', ');
        }

        $this->addToClause("$variable.$label");
    }

    /**
     * @todo Removing Labels from a node, Removing multiple labels from a node
     */
}
