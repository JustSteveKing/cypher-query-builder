<?php

declare(strict_types=1);

namespace JustSteveKing\Tests\Graph\Builder\Clause;

use JustSteveKing\Graph\Builder\Clause\ReturnClause;
use PHPUnit\Framework\TestCase;

class ReturnClauseTest extends TestCase
{
    public function buildClause()
    {
        return new ReturnClause();
    }

    /**
     * @test
     */
    public function it_can_create_a_new_return_clause_instance()
    {
        $this->assertInstanceOf(
            ReturnClause::class,
            $this->buildClause()
        );
    }

    /**
     * @test
     */
    public function it_returns_a_single_condition()
    {
        $clause = $this->buildClause();
        $clause->return('test');

        $this->assertEquals(
            "RETURN test",
            $clause->getClause()
        );
    }

    /**
     * @test
     */
    public function it_returns_a_single_condition_with_an_attribute()
    {
        $clause = $this->buildClause();
        $clause->return('test', 'case');

        $this->assertEquals(
            "RETURN test.case",
            $clause->getClause()
        );
    }

    /**
     * @test
     */
    public function it_can_return_multiple_conditions()
    {
        $clause = $this->buildClause();
        $clause->return('test');

        $this->assertEquals(
            "RETURN test",
            $clause->getClause()
        );

        $clause->return('language');

        $this->assertEquals(
            "RETURN test, language",
            $clause->getClause()
        );
    }

    /**
     * @test
     */
    public function it_can_return_multiple_conditions_with_attributes()
    {
        $clause = $this->buildClause();
        $clause->return('test', 'case');

        $this->assertEquals(
            "RETURN test.case",
            $clause->getClause()
        );

        $clause->return('programming', 'language');

        $this->assertEquals(
            "RETURN test.case, programming.language",
            $clause->getClause()
        );
    }
}
