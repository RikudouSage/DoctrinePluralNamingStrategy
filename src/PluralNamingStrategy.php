<?php

namespace Rikudou\DoctrinePluralNamingStrategy;

use Doctrine\ORM\Mapping\NamingStrategy;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Symfony\Component\String\Inflector\InflectorInterface;

final class PluralNamingStrategy implements NamingStrategy
{
    /**
     * @var UnderscoreNamingStrategy
     */
    private $original;

    /**
     * @var InflectorInterface
     */
    private $inflector;

    public function __construct(UnderscoreNamingStrategy $original, InflectorInterface $inflector)
    {
        $this->original = $original;
        $this->inflector = $inflector;
    }

    /**
     * @inheritDoc
     */
    function classToTableName(string $className): string
    {
        $original = $this->original->classToTableName($className);
        return $this->inflector->pluralize($original)[0];
    }

    /**
     * @inheritDoc
     */
    function propertyToColumnName(string $propertyName, string $className): string
    {
        return $this->original->propertyToColumnName($propertyName, $className);
    }

    /**
     * @inheritDoc
     */
    function embeddedFieldToColumnName(string $propertyName, string $embeddedColumnName, string $className, string $embeddedClassName): string
    {
        return $this->original->embeddedFieldToColumnName($propertyName, $embeddedColumnName, $className, $embeddedClassName);
    }

    /**
     * @inheritDoc
     */
    function referenceColumnName(): string
    {
        return $this->original->referenceColumnName();
    }

    /**
     * @inheritDoc
     */
    function joinColumnName(string $propertyName, string $className): string
    {
        return $this->original->joinColumnName($propertyName, $className);
    }

    /**
     * @inheritDoc
     */
    function joinTableName(string $sourceEntity, string $targetEntity, string $propertyName): string
    {
        return sprintf(
            '%s_x_%s',
            $this->classToTableName($sourceEntity),
            $this->classToTableName($targetEntity)
        );
    }

    /**
     * @inheritDoc
     */
    function joinKeyColumnName(string $entityName, ?string $referencedColumnName = null): string
    {
        return $this->original->joinKeyColumnName($entityName, $referencedColumnName);
    }
}
