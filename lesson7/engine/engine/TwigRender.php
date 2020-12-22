<?php


namespace app\engine;
use app\interfaces\IRenderer;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRender implements IRenderer
{
    private $twig;

    public function __construct()
    {

        $this->twig = new Environment(
            new FilesystemLoader(App::call()->config['twig_templates']),[
//                'cache' => '../cache/TwigCache'
                //TODO Кэширование убрал, иначе при изменении шаблонов приходится чистить кэш
            ]
        );
    }

    public function renderTemplate($template, $params)
    {
        $templatePath = $template . ".twig";
        if (file_exists(App::call()->config['twig_templates'] . $templatePath)){
            return $this->twig->render($templatePath, $params);
        }else{
            vdd($templatePath);
        }
    }
}