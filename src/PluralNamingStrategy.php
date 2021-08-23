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
    function classToTableName($className)
    {
        $original = $this->original->classToTableName($className);
        return $this->inflector->pluralize($original)[0];
    }

    /**
     * @inheritDoc
     */
    function propertyToColumnName($propertyName, $className = null)
    {
        return $this->original->propertyToColumnName($propertyName, $className);
    }

    /**
     * @inheritDoc
     */
    function embeddedFieldToColumnName($propertyName, $embeddedColumnName, $className = null, $embeddedClassName = null)
    {
        return $this->original->embeddedFieldToColumnName($propertyName, $embeddedColumnName, $className, $embeddedClassName);
    }

    /**
     * @inheritDoc
     */
    function referenceColumnName()
    {
        return $this->original->referenceColumnName();
    }

    /**
     * @inheritDoc
     */
    function joinColumnName($propertyName)
    {
        return $this->original->joinColumnName($propertyName);
    }

    /**
     * @inheritDoc
     */
    function joinTableName($sourceEntity, $targetEntity, $propertyName = null)
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
    function joinKeyColumnName($entityName, $referencedColumnName = null)
    {
        return $this->original->joinKeyColumnName($entityName, $referencedColumnName);
    }
}
