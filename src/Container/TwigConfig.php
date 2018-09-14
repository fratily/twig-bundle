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
namespace Fratily\Bundle\Twig\Container;

use Fratily\Container\Container;
use Fratily\Container\ContainerConfig;

class TwigConfig extends ContainerConfig{

    /**
     * @var bool
     */
    private $debug;

    /**
     * Constructor
     *
     * @param   bool    $debug
     *  デバッグモードが有効か
     */
    public function __construct(bool $debug){
        $this->debug    = $debug;
    }

    /**
     * {@inheritdoc}
     */
    public function define(Container $container){
        $container
            ->set("twig", \Twig_Environment::class)
            ->set("twig.loader", \Twig_Loader_Chain::class)
        ;

        $container
            ->param(
                \Twig_Environment::class,
                "loader",
                $container->lazyGet("twig.loader")
            )
            ->param(
                \Twig_Environment::class,
                "options",
                $container->lazyArray(
                    [
                        "debug"                 => $container->lazyValue("twig.option.debug"),
                        "charset"               => $container->lazyValue("twig.option.charset"),
                        "base_template_class"   => $container->lazyValue("twig.option.base_template_class"),
                        "strict_variables"      => $container->lazyValue("twig.option.strict_variables"),
                        "autoescape"            => $container->lazyValue("twig.option.autoescape"),
                        "cache"                 => $container->lazyValue("twig.option.cache"),
                        "auto_reload"           => $container->lazyValue("twig.option.auto_reload"),
                        "optimizations"         => $container->lazyValue("twig.option.optimizations"),
                    ]
                )
            )
        ;

        $container
            ->value("twig.option.debug", $this->debug)
            ->value("twig.option.charset", "UTF-8")
            ->value("twig.option.base_template_class", "Twig_Template")
            ->value("twig.option.strict_variables", false)
            ->value("twig.option.autoescape", "html")
            ->value("twig.option.cache", false)
            ->value("twig.option.auto_reload", null)
            ->value("twig.option.optimizations", -1)
        ;
    }
}