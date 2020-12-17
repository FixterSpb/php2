<?php


namespace app\engine;
use app\interfaces\IRenderer;

class TwigRender implements IRenderer
{
    private $twig;

    public function __construct()
    {

        $this->twig = new \Twig\Environment(
            new \Twig\Loader\FilesystemLoader(TWIG_TEMPLATES),[
//                'cache' => '../cache/TwigCache'
                //TODO Кэширование убрал, иначе при изменении шаблонов приходится чистить кэш
            ]


        );
    }

    public function renderTemplate($template, $params)
    {
        $templatePath = $template . ".twig";
        if (file_exists(TWIG_TEMPLATES . $templatePath)){
            return $this->twig->render($templatePath, $params, );
        }else{
            vdd($templatePath);
        }
    }
}