<?php

namespace App\Type;

use App\Enum\ApiResponseResultEnum;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Exception;

/**
 * Class ApiResponseResultType
 *
 * @package App\Type
 */
class ApiResponseResultType extends Type
{
    const DOCTRINE_TYPE = 'api_response_result';

    /**
     * Gets the SQL declaration snippet for a field of this type.
     *
     * @param array            $column   The field declaration.
     * @param AbstractPlatform $platform The currently used database platform.
     *
     * @return string
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($column);
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     *
     * @return ApiResponseResultEnum
     * @throws Exception
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new ApiResponseResultEnum($value);
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     *
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var ApiResponseResultEnum $value */
        return $value->getValue();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::DOCTRINE_TYPE;
    }

    /**
     * @param AbstractPlatform $platform
     *
     * @return bool
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform) 
    {
        return true;
    }
}
