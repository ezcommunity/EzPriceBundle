<?php
/**
 * This file is part of the EzPriceBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\EzPriceBundle\Twig\Extension;

use eZ\Publish\API\Repository\Values\Content\Field;
use Twig_Extension;
use Twig_SimpleFunction;

class PriceExtension extends Twig_Extension
{
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "ezprice";
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction(
                'ezprice_value',
                array( $this, 'priceValue' ),
                array( 'is_safe' => array( 'html' ) )
            )
        );
    }

    /**
     * Returns the price associated to the Field $price without VAT applied
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Field $price
     *
     * @return string
     */
    public function priceValue( Field $price )
    {
    }
}
