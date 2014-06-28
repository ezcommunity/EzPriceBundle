<?php
/**
 * This file is part of the EzPriceBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\EzPriceBundle\Twig\Extension;

use eZ\Publish\API\Repository\Values\Content\Field;
use eZ\Publish\API\Repository\Values\Content\VersionInfo;
use EzSystems\EzPriceBundle\API\Price\PriceValueWithVatDataCalculator;
use EzSystems\EzPriceBundle\API\Price\VatService;
use Twig_Extension;
use Twig_SimpleFunction;

class PriceExtension extends Twig_Extension
{
    /** @var \EzSystems\EzPriceBundle\API\Price\VatService */
    private $vatService;

    /** @var \EzSystems\EzPriceBundle\API\Price\PriceValueWithVatDataCalculator */
    private $calculator;

    public function __construct( VatService $vatService, PriceValueWithVatDataCalculator $calculator )
    {
        $this->vatService = $vatService;
        $this->calculator = $calculator;
    }
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
     * Returns the price associated to the Field $price and Version $versionNo without VAT applied
     *
     * @param \eZ\Publish\API\Repository\Values\Content\VersionInfo $versionInfo
     * @param \eZ\Publish\API\Repository\Values\Content\Field $price
     *
     * @return string
     */
    public function priceValue( VersionInfo $versionInfo, Field $price )
    {
        return $this->calculator->getValueWithVatData(
            $price->value,
            $this->vatService->loadVatRate( $price->id, $versionInfo->versionNo )
        );

    }
}
