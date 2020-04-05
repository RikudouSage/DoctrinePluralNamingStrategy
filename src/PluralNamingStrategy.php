<?php

namespace Rikudou\DoctrinePluralNamingStrategy;

use Doctrine\ORM\Mapping\NamingStrategy;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Symfony\Component\Inflector\Inflector;

final class PluralNamingStrategy implements NamingStrategy
{
    /**
     * @var UnderscoreNamingStrategy
     */
    private $original;

    public function __construct(UnderscoreNamingStrategy $original)
    {
        $this->original = $original;
    }

    /**
     * @inheritDoc
     */
    function classToTableName($className)
    {
        $original = $this->original->classToTableName($className);
        $pluralized = Inflector::pluralize($original);
        if (is_array($pluralized)) {
            $pluralized = $pluralized[0];
        }

        return $pluralized;
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
