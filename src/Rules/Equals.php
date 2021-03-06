<?php

/**
 * Equals rule.
 *
 * PHP Version 7.2.11-3
 *
 * @package   Verum-PHP
 * @license   MIT https://github.com/SandroMiguel/verum-php/blob/master/LICENSE
 * @author    Sandro Miguel Marques <sandromiguel@sandromiguel.com>
 * @copyright 2020 Sandro
 * @since     Verum-PHP 1.0.0
 * @version   4.0.2 (25/06/2020)
 * @link      https://github.com/SandroMiguel/verum-php
 */

declare(strict_types=1);

namespace Verum\Rules;

use Verum\Exceptions\ValidatorException;

/**
 * Class Equals | core/Verum/Rules/Equals.php
 * Checks whether the value is equal to another.
 */
final class Equals extends Rule
{
    /** @var string Field Name to compare */
    private $fieldNameToCompare;

    /** @var string Field value to compare */
    private $fieldValueToCompare;

    /** @var string First field label */
    private $labelNameA;

    /** @var string Second field label */
    private $labelNameB;

    /**
     * Equals constructor.
     *
     * @param mixed $fieldValue Field Value to validate.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 3.0.0 (09/06/2020)
     * @since   Verum 1.0.0
     */
    public function __construct($fieldValue)
    {
        $this->fieldValue = $fieldValue;
    }

    /**
     * Validate.
     *
     * @return bool Returns TRUE if it passes the validation, FALSE otherwise.
     *
     * @throws ValidatorException Validator Exception.
     *
     * @version 2.0.1 (25/06/2020)
     * @since   Verum 1.0.0
     */
    public function validate(): bool
    {
        if (!isset($this->ruleValues[0])) {
            throw ValidatorException::invalidArgument(
                '$ruleValues',
                $this->ruleValues[0] ?? 'null',
                'Rule "equals": the rule value is mandatory'
            );
        }
        $this->fieldNameToCompare = $this->ruleValues[0];
        $this->fieldValueToCompare = $this
            ->validator->getFieldValues()[$this->fieldNameToCompare];
        $this->labelNameA = $this
            ->validator
            ->getFieldRules()[$this->fieldNameToCompare]['label'] ?? null;
        $this->labelNameB = $this
            ->validator
            ->getFieldRules()[$this->fieldNameUnderTest]['label'] ?? null;

        return $this->fieldValue === $this->fieldValueToCompare;
    }

    /**
     * Error Message Parameters.
     *
     * @return array<int, string> Returns the parameters for the error message.
     *
     * @version 1.0.0 (15/05/2020)
     * @since   Verum 1.0.0
     */
    public function getErrorMessageParameters(): array
    {
        return [$this->labelNameA, $this->labelNameB];
    }
}
