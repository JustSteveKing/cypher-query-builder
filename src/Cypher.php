<?php

declare(strict_types=1);

namespace JustSteveKing\Graph\Builder;

use JustSteveKing\Graph\Builder\Clause\Clause;
use JustSteveKing\Graph\Builder\Clause\CreateClause;
use JustSteveKing\Graph\Builder\Clause\DeleteClause;
use JustSteveKing\Graph\Builder\Clause\MatchClause;
use JustSteveKing\Graph\Builder\Clause\RemoveClause;
use JustSteveKing\Graph\Builder\Clause\ReturnClause;
use JustSteveKing\Graph\Builder\Clause\SetClause;
use JustSteveKing\Graph\Builder\Clause\WhereClause;

class Cypher
{
    /**
     * @var CreateClause
     */
    protected CreateClause $createClause;

    /**
     * @var SetClause
     */
    protected SetClause $setClause;

    /**
     * @var DeleteClause
     */
    protected DeleteClause $deleteClause;

    /**
     * @var RemoveClause
     */
    protected RemoveClause $removeClause;

    /**
     * @var MatchClause
     */
    protected MatchClause $matchClause;

    /**
     * @var WhereClause
     */
    protected WhereClause $whereClause;

    /**
     * @var ReturnClause
     */
    protected ReturnClause $returnClause;

    /**
     * @var array
     */
    protected array $clauses = [];

    /**
     * @var array
     */
    protected array $generatedMethods;

    /**
     * Cypher constructor.
     *
     * @return void
     */
    private function __construct()
    {
        $this->createClause = new CreateClause();
        $this->setClause = new SetClause();
        $this->deleteClause = new DeleteClause();

        $this->removeClause = new RemoveClause();

        $this->matchClause = new MatchClause();
        $this->whereClause = new WhereClause();

        $this->returnClause = new ReturnClause();

        $this->clauses = [
            $this->createClause,
            $this->setClause,
            $this->deleteClause,
            $this->removeClause,
            $this->matchClause,
            $this->whereClause,
            $this->returnClause,
        ];

        $this->createCustomAppendMethods();
    }

    /**
     * For every clause we create a Closure method which we cache while building our query.
     *
     * @return void
     */
    protected function createCustomAppendMethods(): void
    {
        foreach ($this->clauses as $clause) {
            $this->createAppendMethod($clause);
        }
    }

    /**
     * @param Clause $clause
     */
    protected function createAppendMethod(Clause $clause): void
    {
        $clauseAttributeString = strtolower($clause->getName()) . 'Clause';
        $appendFunc = function ($string) use ($clauseAttributeString) {
            $this->$clauseAttributeString->addToClause($string);
            return $this;
        };

        $funcName = 'appendTo' . ucwords(strtolower($clause->getName()));

        $this->generatedMethods[$funcName] = \Closure::bind($appendFunc, $this, get_class());
    }

    /**
     * Create a match query
     *
     * @param string $label
     * @param string $variable
     * @return $this
     */
    public function match(string $label, string $variable = '') : self
    {
        $this->matchClause->match($label, $variable);

        return $this;
    }

    /**
     * Create a where query
     *
     * @param string $variable
     * @param string $attribute
     * @param string $operator
     * @param string $value
     * @param bool $or
     * @return $this
     */
    public function where(string $variable, string $attribute, string $operator, string $value, bool $or = false) : self
    {
        $this->whereClause->where($variable, $attribute, $operator, $value, $or);

        return $this;
    }

    /**
     * An easy to run short cut to return a cypher query string
     *
     * @return string
     */
    public function raw() : string
    {
        return $this->__toString();
    }

    /**
     * Static query method to call and return a new instance.
     *
     * @return self
     */
    public static function query(): self
    {
        return new self();
    }

    /**
     * Return the Clauses that are registered
     *
     * @return array
     */
    public function getClauses(): array
    {
        return $this->clauses;
    }

    /**
     * Return the clauses as a string
     *
     * @return string
     */
    public function __toString() : string
    {
        $clauseStrings = [];

        foreach ($this->clauses as $clause) {
            if (! empty($clause->getClause())) {
                $clauseStrings[] = $clause->getClause();
            }
        }

        return implode(' ', $clauseStrings);
    }
}
