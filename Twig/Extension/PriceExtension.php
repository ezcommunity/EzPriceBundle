<?php
/**
 * This file is part of the EzPriceBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\EzPriceBundle\Twig\Extension\PriceExtension;

use Twig_Extension;

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
}
