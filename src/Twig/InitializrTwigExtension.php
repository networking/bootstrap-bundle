<?php

/*
 * This file is part of the MopaBootstrapBundle.
 *
 * (c) Philipp A. Mohrenweiser <phiamo@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Networking\BootstrapBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

/**
 * Reads Initializr configuration file and generates
 * corresponding Twig Globals.
 *
 * @author Paweł Madej (nysander) <pawel.madej@profarmaceuta.pl>
 */
class InitializrTwigExtension extends AbstractExtension implements GlobalsInterface
{
    /**
     * @var array
     */
    protected $parameters;

    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    public function getGlobals(): array
    {
        return [
            'dns_prefetch' => $this->parameters['dns_prefetch'],
            'meta' => $this->parameters['meta'],
            'google' => $this->parameters['google'],
            'diagnostic_mode' => $this->parameters['diagnostic_mode'],
        ];
    }
}
