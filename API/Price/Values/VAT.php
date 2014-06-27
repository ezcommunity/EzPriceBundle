<?php
/**
 * This file is part of the EzPriceBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\EzPriceBundle\API\Price\Values;

use eZ\Publish\API\Repository\Values\ValueObject;

/**
 * Class representing a VAT
 *
 */
class VAT extends ValueObject
{
    /**
     * VAT id
     *
     * @var int
     */
    protected $id;

    /**
     * Name of the VAT
     *
     * @var string
     */
    protected $name;

    /**
     * Percentage associated with vat
     *
     * @var float
     */
    protected $percentage;
}