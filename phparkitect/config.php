<?php
declare(strict_types=1);

use Arkitect\ClassSet;
use Arkitect\CLI\Config;
use Arkitect\Expression\ForClasses\NotDependsOnTheseNamespaces;
use Arkitect\Expression\ForClasses\NotHaveDependencyOutsideNamespace;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Rules\Rule;

return static function (Config $config): void
{
    $srcClassSet = ClassSet::fromDir(__DIR__.'/src');

    $rules = [];
    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('Domain'))
        ->should(new NotHaveDependencyOutsideNamespace('Domain'))
        ->because('Domain shall stand alone!')
    ;
    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('Application'))
        ->should(new NotDependsOnTheseNamespaces('Infrastructure', 'Presentation'))
        ->because('Application should orchestrate Domain')
    ;
    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('Infrastructure'))
        ->should(new NotDependsOnTheseNamespaces('Presentation'))
        ->because('Infrastructure supports Domain and Application')
    ;

    $config->add($srcClassSet, ...$rules);
};
