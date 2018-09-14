<?php
/**
 * FratilyPHP Framework Bundle
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Kento Oka <kento-oka@kentoka.com>
 * @copyright   (c) Kento Oka
 * @license     MIT
 * @since       1.0.0
 */
namespace Fratily\Bundle\Twig;

use Fratily\Kernel\Bundle\Bundle;

class TwigBundle extends Bundle{

    public function registerContainerConfigurations(){
        return [
            new Container\TwigConfig($this->isDebug()),
        ];
    }
}