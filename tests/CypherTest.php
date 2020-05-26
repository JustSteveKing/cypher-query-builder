<?php

declare(strict_types=1);

namespace JustSteveKing\Tests\Graph\Builder;

use PHPUnit\Framework\TestCase;
use JustSteveKing\Graph\Builder\Cypher;

class CypherTest extends TestCase
{
    public function buildCypher()
    {
        return Cypher::query();
    }

    /**
     * @test
     */
    public function it_can_create_a_new_cypher_instance()
    {
        $this->assertInstanceOf(
            Cypher::class,
            $this->buildCypher()
        );
    }

    /**
     * @test
     */
    public function it_can_have_initial_clauses_on_construction()
    {
        $cypher = $this->buildCypher();

        $clauses = $cypher->getClauses();

        $this->assertIsArray($clauses);
        $this->assertTrue(! empty($clauses));
    }

    /**
     * @test
     */
    public function it_can_add_a_match_clause()
    {
        $cypher = $this->buildCypher();

        $cypher->match('A', 'a');

        $this->assertTrue(
            ($cypher->raw() !== '')
        );

        $this->assertEquals(
            "MATCH (a:A)",
            $cypher->raw()
        );
    }

    /**
     * @test
     */
    public function it_can_return_the_build_query_as_a_string()
    {
        $cypher = $this->buildCypher();

        $cypher->match('A', 'a');

        $this->assertEquals(
            "MATCH (a:A)",
            $cypher->raw()
        );

        $this->assertEquals(
            "MATCH (a:A)",
            (string) $cypher
        );

        $this->assertEquals(
            "MATCH (a:A)",
            $cypher->__toString()
        );

    }
}
