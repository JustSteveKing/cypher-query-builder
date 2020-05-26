<?php

declare(strict_types=1);

namespace JustSteveKing\Tests\Graph\Builder\Clause;

use PHPUnit\Framework\TestCase;
use JustSteveKing\Graph\Builder\Clause\CreateClause;

class CreateClauseTest extends TestCase
{
    public function buildClause()
    {
        return new CreateClause();
    }

    /**
     * @test
     */
    public function it_can_create_a_new_create_clause_instance()
    {
        $this->assertInstanceOf(
            CreateClause::class,
            $this->buildClause()
        );
    }

    /**
     * @test
     */
    public function it_can_create_a_create_clause_with_no_properties()
    {
        $clause = $this->buildClause();

        $clause->create('test', 'Test');

        $this->assertEquals(
            "CREATE (test:Test)",
            $clause->getClause()
        );
    }

    /**
     * @test
     */
    public function it_can_create_a_create_clause_with_multiple_properties()
    {
        $clause = $this->buildClause();

        $clause->create('framework', 'Framework', ['language' => 'PHP', 'name' => 'PHPUnit']);

        $this->assertEquals(
            'CREATE (framework:Framework { language: "PHP", name: "PHPUnit" })',
            $clause->getClause()
        );
    }

    /**
     * @test
     */
    public function it_will_throw_an_exception_if_not_supported_types_for_property()
    {
        $clause = $this->buildClause();

        $this->expectException(\RuntimeException::class);

        $clause->create('exception', 'type', ['data' => ['Runtime Exception']]);
    }
}
