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

use Fratily\Container\Builder\AbstractContainer;
use Fratily\Container\Builder\ContainerBuilderInterface;

class TwigContainer extends AbstractContainer{

    /**
     * {@inheritdoc}
     */
    public static function build(ContainerBuilderInterface $builder, array $options){
        $builder
            ->add(
                "twig",
                \Twig_Environment::class,
                [],
                [
                    \Twig\Environment::class,
                    \Twig_Environment::class,
                ]
            )
            ->add(
                "twig.loader",
                \Twig_Loader_Chain::class,
                [],
                [
                    \Twig\Loader\LoaderInterface::class,
                    \Twig_LoaderInterface::class,
                ]
            )
        ;

        $builder->parameter(\Twig_Environment::class)
            ->add("loader", $builder->lazyGet("twig.loader"))
        ;

        $builder->parameter(\Twig_Loader_Chain::class)
            ->add(
                "options",
                $builder->lazyArray([
                    "debug" => $options["debug"]
                ])
            )
        ;

        $builder->setter(\Fratily\Bundle\Twig\Controller\Traits\TwigTrait::class)
            ->add("setTwigEnvironment", $builder->lazyGet("twig"))
        ;
    }

    public static function modify(\Fratily\Container\Container $container){
        $loader = $container->get("twig.loader");

        foreach($container->getTagged("twig.loader") as $subLoader){
            $loader->addLoader($subLoader);
        }
    }
}