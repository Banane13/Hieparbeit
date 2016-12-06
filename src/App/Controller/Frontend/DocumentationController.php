<?php
namespace App\Controller\Frontend;

class DocumentationController extends FrontendController
{

    public function indexAction()
    {
        $this->setTemplateName('documentation');
        $this->setPageTitle('Dokumentation');

        return $this->getResponse();

    }

}