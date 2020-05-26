<?php

declare(strict_types=1);

namespace JustSteveKing\Tests\Graph\Builder\Clause;

use PHPUnit\Framework\TestCase;
use JustSteveKing\Graph\Builder\Clause\SetClause;

class SetClauseTest extends TestCase
{
    public function buildClause()
    {
        return new SetClause();
    }

    /**
     * @test
     */
    public function it_can_set_a_single_property()
    {
        $clause = $this->buildClause();
        $clause->set('framework', 'name', 'PHPUnit');
        $this->assertEquals(
            'SET framework.name = "PHPUnit"',
            $clause->getClause()
        );
    }

    /**
     * @test
     */
    public function it_can_set_multiple_properties()
    {
        $clause = $this->buildClause();
        $clause->set('framework', 'name', 'PHPUnit');
        $this->assertEquals(
            'SET framework.name = "PHPUnit"',
            $clause->getClause()
        );

        $clause->set('framework', 'version', 9.1);
        $this->assertEquals(
            'SET framework.name = "PHPUnit", framework.version = 9.1',
            $clause->getClause()
        );
    }

    /**
     * @test
     */
    public function it_will_throw_an_exception_on_an_unsupported_property_type()
    {
        $clause = $this->buildClause();
        $this->expectException(\RuntimeException::class);
        $clause->set('test', 'fails', ['data' => 'Have a runtime exception for fun']);
    }
}
