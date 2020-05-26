<?php

declare(strict_types=1);

namespace JustSteveKing\Tests\Graph\Builder\Clause;

use PHPUnit\Framework\TestCase;
use JustSteveKing\Graph\Builder\Clause\MatchClause;

class MatchClauseTest extends TestCase
{
    public function buildClause()
    {
        return new MatchClause();
    }

    /**
     * @test
     */
    public function it_can_create_a_new_match_clause_instance()
    {
        $this->assertInstanceOf(
            MatchClause::class,
            $this->buildClause()
        );
    }

    /**
     * @test
     */
    public function it_can_match_a_single_node()
    {
        $clause = $this->buildClause();
        $clause->match('phpunit');
        $this->assertEquals(
            'MATCH (:phpunit)',
            $clause->getClause()
        );
    }

    /**
     * @test
     */
    public function it_can_match_two_nodes_and_a_relationship()
    {
        $clause = $this->buildClause();
        $clause->match('Developer');
        $this->assertEquals(
            'MATCH (:Developer)',
            $clause->getClause()
        );

        // Can't assert as cannot end on a relationship clause
        $clause->match('LIKES');

        $clause->match('PHPUnit');

        $this->assertEquals(
            "MATCH (:Developer)-[:LIKES]-(:PHPUnit)",
            $clause->getClause()
        );
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_ending_with_a_relationship()
    {
        $clause = $this->buildClause();

        $clause->match('User');
        $this->assertEquals(
            'MATCH (:User)',
            $clause->getClause()
        );

        $clause->match('LIKES');
        $this->expectException(\RuntimeException::class);
        $clause->getClause();
    }

    /**
     * @test
     */
    public function it_can_create_a_left_match()
    {
        $clause = $this->buildClause();
        $clause->match('Developer');
        $this->assertEquals(
            'MATCH (:Developer)',
            $clause->getClause()
        );

        $clause->leftMatch('LIKES');

        $clause->match('PHPUnit');

        $this->assertEquals(
            "MATCH (:Developer)<-[:LIKES]-(:PHPUnit)",
            $clause->getClause()
        );
    }

    /**
     * @test
     */
    public function it_can_create_a_right_match()
    {
        $clause = $this->buildClause();
        $clause->match('Developer');
        $this->assertEquals(
            'MATCH (:Developer)',
            $clause->getClause()
        );

        $clause->rightMatch('LIKES');

        $clause->match('PHPUnit');

        $this->assertEquals(
            "MATCH (:Developer)-[:LIKES]->(:PHPUnit)",
            $clause->getClause()
        );
    }

    /**
     * @test
     */
    public function it_can_create_a_multi_match_clause()
    {
        $clause = $this->buildClause();
        $clause->match('Person', 'person');

        $this->assertEquals(
            "MATCH (person:Person)",
            $clause->getClause()
        );

        $clause->end();
        $clause->match('Cat', 'cat');

        $this->assertEquals(
            "MATCH (person:Person) MATCH (cat:Cat)",
            $clause->getClause()
        );
    }
}
