<?php

declare(strict_types=1);

namespace JustSteveKing\Tests\Graph\Builder\Clause;

use PHPUnit\Framework\TestCase;
use JustSteveKing\Graph\Builder\Clause\WhereClause;

class WhereClauseTest extends TestCase
{
    public function buildClause()
    {
        return new WhereClause();
    }

    /**
     * @test
     */
    public function it_can_create_a_new_where_clause_instance()
    {
        $this->assertInstanceOf(
            WhereClause::class,
            $this->buildClause()
        );
    }

    /**
     * @test
     */
    public function it_starts_with_an_empty_clause()
    {
        $this->assertEmpty(
            $this->buildClause()->getClause()
        );
    }

    /**
     * @test
     */
    public function it_can_create_a_single_where_condition()
    {
        $clause = $this->buildClause();
        $clause->where('testing', 'framework', '=', 'PHPUnit');

        $this->assertEquals(
            'WHERE testing.framework = "PHPUnit"',
            $clause->getClause()
        );
    }

    /**
     * @test
     */
    public function it_can_create_a_single_where_condition_not_using_a_string()
    {
        $clause = $this->buildClause();
        $clause->where('date', 'year', '=', 2020);

        $this->assertEquals(
            'WHERE date.year = 2020',
            $clause->getClause()
        );
    }

    /**
     * @test
     */
    public function it_can_create_an_and_where_condition()
    {
        $clause = $this->buildClause();
        $clause->where('programming', 'language', '=', 'PHP');

        $this->assertEquals(
            'WHERE programming.language = "PHP"',
            $clause->getClause()
        );

        $clause->where('testing', 'framework', '=', 'PHPUnit');

        $this->assertStringContainsString(
            'AND',
            $clause->getClause()
        );

        $this->assertEquals(
            'WHERE programming.language = "PHP" AND testing.framework = "PHPUnit"',
            $clause->getClause()
        );
    }

    /**
     * @test
     */
    public function it_can_create_an_or_where_condition()
    {
        $clause = $this->buildClause();
        $clause->where('programming', 'language', '=', 'PHP');

        $this->assertEquals(
            'WHERE programming.language = "PHP"',
            $clause->getClause()
        );

        $clause->where('testing', 'framework', '=', 'PHPUnit', true);

        $this->assertStringContainsString(
            'OR',
            $clause->getClause()
        );

        $this->assertEquals(
            'WHERE programming.language = "PHP" OR testing.framework = "PHPUnit"',
            $clause->getClause()
        );
    }
}
