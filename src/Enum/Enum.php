<?php

namespace App\Enum;

use App\Exception\EnumValueException;

/**
 * @package App\Utility
 */
abstract class Enum {

    const ARRAY_KEY_VALUE = 'value';
    const ARRAY_KEY_LABEL = 'label';

    /**
     * @var array
     */
    protected static $options = [];

    /**
     * @var string
     */
    protected $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->assertValueIsValid($value);

        $this->value = $value;
    }

    /**
     * @param mixed $input
     *
     * @return bool
     */
    public static function isValidOption($input): bool
    {
        return is_string($input) && in_array($input, static::$options);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @throws EnumValueException
     */
    private function assertValueIsValid(string $value): void
    {
        if (!self::isValidOption($value)) {
            throw new EnumValueException(
                            "Invalid value for creation of a " . static::class . " enum. " . $value .
                            " used while only one of: " . implode("|", static::getOptions()) . " is allowed."
            );
        }
    }
}
