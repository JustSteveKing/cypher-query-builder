<?php

declare(strict_types=1);

namespace JustSteveKing\Graph\Builder\Clause;

class MatchClause extends Clause
{
    /**
     * @var string
     */
    protected string $name = 'MATCH';

    /**
     * @var bool
     */
    protected bool $relation = false;

    /**
     * Create a MATCH clause
     *
     * @param string $label
     * @param string $variable
     *
     * @return void
     */
    public function match(string $label, string $variable = ''): void
    {
        if (!$this->relation) {
            $this->nodeMatch($label, $variable);
        } else {
            $this->relationshipMatch($label, $variable);
        }

        $this->relation = !$this->relation;
    }

    /**
     * Create a MATCH Clause on a node
     *
     * @param string $label
     * @param string $variable
     *
     * @return void
     */
    public function nodeMatch(string $label, string $variable): void
    {
        $this->addToClause("($variable:$label)");
    }

    /**
     * Create a MATCH Clause on a Relation
     *
     * @param string $label
     * @param string $variable
     *
     * @return void
     */
    public function relationshipMatch(string $label, string $variable): void
    {
        $this->addToClause("-[$variable:$label]-");
    }

    /**
     * Create a Left Match Clause
     *
     * @param string $label
     * @param string $variable
     */
    public function leftMatch(string $label, string $variable = ''): void
    {
        if (! $this->relation) {
            throw new \RuntimeException('Directional matches must be made on relationships not nodes');
        }

        $this->addToClause('<');
        $this->relationshipMatch($label, $variable);
        $this->relation = ! $this->relation;
    }

    /**
     * Create a Right Match Clause
     *
     * @param string $label
     * @param string $variable
     */
    public function rightMatch(string $label, string $variable = ''): void
    {
        if (! $this->relation) {
            throw new \RuntimeException('Directional matches must be made on relationships not nodes');
        }

        $this->relationshipMatch($label, $variable);
        $this->addToClause('>');
        $this->relation = ! $this->relation;
    }

    /**
     * Get the MATCH Clause
     *
     * @throws \RuntimeException
     * @return string
     */
    public function getClause(): string
    {
        if (! empty($this->clause)) {
            if (! $this->relation) {
                throw new \RuntimeException('MatchClause clauses cannot end with a relationship match.');
            }
        }

        return $this->clause;
    }

    /**
     * End the current clause to chain another match
     *
     * @return void
     */
    public function end() : void
    {
        $this->addToClause(' ');
        $this->booted = false;
        $this->relation = false;
    }
}
