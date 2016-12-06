<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig_Loader_Filesystem;
use Twig_Environment;

abstract class Controller
{
    protected $path = '/../../../templates/';

    private $templateName = null;

    private $pageTitle = null;

    protected $contentData = array();

    /* @var $twig Twig_Environment */
    private $twig;

    private $request;

    private $config;

    public function __construct($config)
    {
        $this->config = $config;
        $this->initTwig();
    }

    protected function getConfig()
    {
        return $this->config;
    }

    protected function getTwig()
    {
        return $this->twig;
    }

    protected function setRequest($request)
    {
        return $this->request = $request;
    }

    protected function getRequest()
    {
        return $this->request;
    }

    protected function setTemplateName($templateName)
    {
        $this->templateName = $templateName;
    }

    protected function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;
    }

    private function initTwig()
    {
        $loader = new Twig_Loader_Filesystem(realpath(dirname(__FILE__)) . $this->path);
        $this->twig = new Twig_Environment($loader, [
            'cache' => false,
            'debug' => true
        ]);
    }
    private function renderTemplate()
    {
        $html = $this->getTwig()->render($this->templateName . '.html.twig', $this->contentData);

        return $html;
    }

    protected function getResponse($data = [])
    {
        $this->setContentData($data);
        $html = $this->renderTemplate();

        return new Response($html);
    }

    protected function setContentData($data = [])
    {
        $this->contentData = array_merge(['pageTitle' => $this->pageTitle], $data);
    }
}