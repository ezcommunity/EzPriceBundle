<?php
/**
 * This file is part of the EzPriceBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\EzPriceBundle\Twig\Extension\PriceExtension;

use EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\Value as PriceValue;
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
                'ez_price_without_vat',
                array( $this, 'priceWithoutVAT' ),
                array( 'is_safe' => array( 'html' ) )
            ),
            new Twig_SimpleFunction(
                'ez_price_with_vat',
                array( $this, 'priceWithVAT' ),
                array( 'is_safe' => array( 'html' ) )
            ),
        );
    }

    /**
     * Returns the price associated to the Price $price without VAT applied
     *
     * @param \EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\Value $price
     *
     * @return string
     */
    public function priceWithoutVAT( PriceValue $price )
    {
    }

    /**
     * Returns the price associated to the Price $price with the VAT applied
     *
     * @param \EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\Value $price
     *
     * @return string
     */
    public function priceWithVAT( PriceValue $price )
    {
    }
}

