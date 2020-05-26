<?php

declare(strict_types=1);

namespace JustSteveKing\Tests\Graph\Builder\Clause;

use JustSteveKing\Graph\Builder\Clause\DeleteClause;
use PHPUnit\Framework\TestCase;

class DeleteClauseTest extends TestCase
{
    public function buildClause()
    {
        return new DeleteClause();
    }

    /**
     * @test
     */
    public function it_can_create_a_delete_clause_statement()
    {
        $clause = $this->buildClause();

        $clause->delete('test');

        $this->assertEquals(
            'DELETE test',
            $clause->getClause()
        );
    }

    /**
     * @test
     */
    public function it_can_create_a_delete_clause_for_multiple()
    {
        $clause = $this->buildClause();

        $clause->delete('test');

        $this->assertEquals(
            'DELETE test',
            $clause->getClause()
        );

        $clause->delete('again');

        $this->assertEquals(
            'DELETE test, again',
            $clause->getClause()
        );
    }
}
