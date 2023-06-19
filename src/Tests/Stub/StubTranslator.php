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
namespace Networking\BootstrapBundle\Tests\Stub;

use Symfony\Contracts\Translation\TranslatorInterface;

class StubTranslator implements TranslatorInterface
{
    public function trans(string $id, array $parameters = [], string $domain = null, string $locale = null): string
    {
        return '[trans]'.\strtr($id, $parameters).'[/trans]';
    }
}
