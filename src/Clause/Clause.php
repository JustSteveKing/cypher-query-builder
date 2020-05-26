<?php

declare(strict_types=1);

namespace JustSteveKing\Graph\Builder\Clause;

class Clause
{
    /**
     * @var string
     */
    protected string $clause = '';

    /**
     * @var string
     */
    protected string $name = '';

    /**
     * @var bool
     */
    protected bool $relation = false;

    /**
     * @var bool
     */
    protected bool $booted = false;

    /**
     * Boot up the Clause
     *
     * @return void
     */
    public function boot(): void
    {
        $this->booted = true;
        $this->addToClause($this->name . ' ');
    }

    /**
     * Build up the current Clause
     *
     * @param string $clause
     * @return void
     */
    public function addToClause(string $clause): void
    {
        if (! $this->booted) {
            $this->boot();
        }

        $this->clause .= $clause;
    }

    /**
     * Return the current Clause
     *
     * @return string
     */
    public function getClause(): string
    {
        return $this->clause;
    }

    /**
     * Get the name for the current Clause
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Helper function to get if this is a relation clause
     *
     * @return bool
     */
    public function getRelation() : bool
    {
        return $this->relation;
    }

        /**
     * A helper function to se if the Clause has been booted up yet.
     *
     * @return bool
     */
    public function isBooted() : bool
    {
        return $this->booted;
    }
}
