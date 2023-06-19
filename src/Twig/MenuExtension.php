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

use Knp\Menu\ItemInterface;
use Knp\Menu\Twig\Helper;
use Networking\BootstrapBundle\Menu\Converter\MenuConverter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Twig Extension for rendering a Bootstrap menu.
 *
 * This function provides some more features
 * than knp_menu_render, but does more or less the same.
 *
 * @author phiamo <phiamo@googlemail.com>
 */
class MenuExtension extends AbstractExtension
{
    /**
     * @var Helper
     */
    protected $helper;

    /**
     * @var MenuConverter
     */
    protected $menuConverter;

    /**
     * @param string $menuTemplate
     */
    public function __construct(Helper $helper, protected $menuTemplate)
    {
        $this->helper = $helper;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('networking_bootstrap_menu', $this->renderMenu(...), ['is_safe' => ['html']]),
        ];
    }

    /**
     * Renders the Menu with the specified renderer.
     *
     * @param string                     $renderer
     *
     * @throws \InvalidArgumentException
     * @return string
     */
    public function renderMenu(\Knp\Menu\ItemInterface|string|array $menu, array $options = [], $renderer = null)
    {
        $options = \array_merge([
            'template' => $this->menuTemplate,
            'currentClass' => 'active',
            'ancestorClass' => 'active',
            'allow_safe_labels' => true,
        ], $options);

        if (!$menu instanceof ItemInterface) {
            $path = [];
            if (\is_array($menu)) {
                if (empty($menu)) {
                    throw new \InvalidArgumentException('The array cannot be empty');
                }
                $path = $menu;
                $menu = \array_shift($path);
            }

            $menu = $this->helper->get($menu, $path, $options);
        }

        $menu = $this->helper->get($menu, [], $options);

        if (isset($options['automenu'])) {
            $this->getMenuConverter()->convert($menu, $options);
        }

        return $this->helper->render($menu, $options, $renderer);
    }

    /**
     * @return MenuConverter
     */
    protected function getMenuConverter()
    {
        if ($this->menuConverter === null) {
            $this->menuConverter = new MenuConverter();
        }

        return $this->menuConverter;
    }
}
