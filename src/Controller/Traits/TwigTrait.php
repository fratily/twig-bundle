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
namespace Fratily\Bundle\Twig\Controller\Traits;

use Fratily\Kernel\Controller\AbstractController;
use Fratily\Http\Message\Response;
use Fratily\Http\Message\StreamFactory;
use Twig_Environment;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

trait TwigTrait{

    /**
     * @var Twig_Environment|null
     */
    private $twigEnvironment    = null;

    /**
     * Twigインスタンスを登録する
     *
     * @param   Twig_Environment    $twigEnvironment
     *  Twigインスタンス
     *
     * @return  void
     */
    public function setTwigEnvironment(Twig_Environment $twigEnvironment){
        $this->twigEnvironment  = $twigEnvironment;
    }

    /**
     * テンプレートエンジンを通して描画したビューを文字列で取得する
     *
     * @param   string  $name
     *  テンプレート名
     * @param   mixed[] $context
     *  テンプレートに渡すパラメータの連想配列
     *
     * @return  string
     */
    protected function renderRaw(string $name, array $context = []): string{
        if(!$this->twigEnvironment instanceof Twig_Environment){
            throw new \LogicException;
        }

        return $this->twigEnvironment->render($name, $context);
    }

    /**
     * テンプレートエンジンを通して描画したビューをボディーに持つレスポンスを取得する
     *
     * レスポンスインスタンスのストリームは、新しいものに置き換えられるので注意
     *
     * @param   string  $name
     *  テンプレート名
     * @param   mixed[] $context
     *  テンプレートに渡すパラメータの連想配列
     * @param   ResponseInterface|null   $response
     *  レスポンスインスタンス
     * @param   StreamFactoryInterface  $streamFactory
     *  ストリームファクトリーインスタンス
     *
     * @return  ResponseInterface
     *
     * @todo    受け取ったレスポンスインスタンスのストリームを活用する
     */
    protected function render(
        string $name,
        array $context = [],
        ResponseInterface $response = null,
        StreamFactoryInterface $streamFactory = null
    ): ResponseInterface{
        $view       = $this->renderRaw($name, $context);
        $factory    = $streamFactory ?? new StreamFactory();
        $response   = $response
            ?? (
                $this instanceof AbstractController
                    ? $this->generateResponse(200, "")
                    : new Response(200)
            )
        ;

        return $response->withBody($factory->createStream($view));
    }
}