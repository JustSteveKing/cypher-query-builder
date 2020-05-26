<?php

declare(strict_types=1);

namespace JustSteveKing\Tests\Graph\Builder\Clause;

use JustSteveKing\Graph\Builder\Clause\MatchClause;
use JustSteveKing\Graph\Builder\Clause\ReturnClause;
use JustSteveKing\Graph\Builder\Clause\WhereClause;
use PHPUnit\Framework\TestCase;
use JustSteveKing\Graph\Builder\Clause\Clause;

class ClauseTest extends TestCase
{
    public function buildClause()
    {
        return new Clause();
    }

    /**
     * @test
     */
    public function it_can_create_a_new_clause_instance()
    {
        $this->assertInstanceOf(
            Clause::class,
            $this->buildClause()
        );
    }

    /**
     * @test
     */
    public function it_can_set_the_booted_property_to_true()
    {
        $clause = $this->buildClause();

        $this->assertEquals(false, $clause->isBooted());

        $clause->boot();

        $this->assertTrue($clause->isBooted());
    }

    /**
     * @test
     */
    public function it_begins_with_a_non_relation_clause()
    {
        $clause = $this->buildClause();

        $this->assertEquals(false, $clause->getRelation());
    }

    /**
     * @test
     */
    public function it_can_add_name_to_clause()
    {
        $clause = $this->buildClause();
        $name = $clause->getName();

        $this->assertSame(
            $name,
            $clause->getClause()
        );
    }

    /**
     * @test
     */
    public function it_can_get_clause_name()
    {
        $clause = new MatchClause();
        $this->assertEquals(
            'MATCH',
            $clause->getName()
        );

        $clause = new WhereClause();
        $this->assertEquals(
            'WHERE',
            $clause->getName()
        );

        $clause = new ReturnClause();
        $this->assertEquals(
            'RETURN',
            $clause->getName()
        );
    }
}
