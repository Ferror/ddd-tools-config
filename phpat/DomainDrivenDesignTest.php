<?php
declare(strict_types=1);

use PhpAT\Rule\Rule;
use PhpAT\Selector\Selector;
use PhpAT\Test\ArchitectureTest;

class DomainDrivenDesignTest extends ArchitectureTest
{
    public function testDomainDoesNotDependOnOtherLayers(): Rule
    {
        return $this->newRule
            ->classesThat(Selector::haveClassName('Domain\*'))
            ->canOnlyDependOn()
            ->classesThat(Selector::havePath('Domain/*'))
            ->andClassesThat(Selector::haveClassName('Domain\*'))
            ->build();
    }

    public function testApplicationDependOnlyOnApplicationAndDomain(): Rule
    {
        return $this->newRule
            ->classesThat(Selector::haveClassName('Application\*'))
            ->canOnlyDependOn()
            ->classesThat(Selector::havePath('Domain/*'))
            ->andClassesThat(Selector::haveClassName('Domain\*'))
            ->andClassesThat(Selector::havePath('Application/*'))
            ->andClassesThat(Selector::haveClassName('Application\*'))
            ->build();
    }

    public function testInfrastructureSupportsDomainAndApplication(): Rule
    {
        return $this->newRule
            ->classesThat(Selector::haveClassName('Infrastructure\*'))
            ->canOnlyDependOn()
            ->classesThat(Selector::havePath('Domain/*'))
            ->andClassesThat(Selector::haveClassName('Domain\*'))
            ->andClassesThat(Selector::havePath('Application/*'))
            ->andClassesThat(Selector::haveClassName('Application\*'))
            ->andClassesThat(Selector::havePath('Infrastructure/*'))
            ->andClassesThat(Selector::haveClassName('Infrastructure\*'))
            ->build();
    }
}
