<?php

declare(strict_types=1);

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
use Twig\TwigFunction;

/**
 * MopaBootstrap Flash Extension.
 *
 * @author Nikolai Zujev (jaymecd) <nikolai.zujev@gmail.com>
 */
class FlashExtension extends AbstractExtension
{
    /**
     * @var array
     */
    protected $mapping = [];

    public function __construct(array $mapping)
    {
        $this->mapping = $mapping;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('networking_bootstrap_flash_mapping', $this->getMapping(...), ['is_safe' => ['html']]),
        ];
    }

    /**
     * Get flash mapping.
     *
     * @return array
     */
    public function getMapping()
    {
        return $this->mapping;
    }
}
