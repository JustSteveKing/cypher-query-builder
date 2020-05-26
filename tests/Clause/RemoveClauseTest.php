<?php

declare(strict_types=1);

namespace JustSteveKing\Tests\Graph\Builder\Clause;

use PHPUnit\Framework\TestCase;
use JustSteveKing\Graph\Builder\Clause\RemoveClause;

class RemoveClauseTest extends TestCase
{
    public function buildClause()
    {
        return new RemoveClause();
    }

    /**
     * @test
     */
    public function it_can_create_a_new_remoev_clause_instance()
    {
        $this->assertInstanceOf(
            RemoveClause::class,
            $this->buildClause()
        );
    }

    /**
     * @test
     */
    public function it_can_remove_a_single_property()
    {
        $clause = $this->buildClause();

        $clause->remove('please', 'remove');
        $this->assertEquals(
            'REMOVE please.remove',
            $clause->getClause()
        );
    }
}
