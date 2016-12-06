<?php
namespace App\Controller\Frontend;

class ImpressumController extends FrontendController
{
    public function indexAction()
    {
        $this->setTemplateName('impressum');
        $this->setPageTitle('Impressum');

        return $this->getResponse();
    }
}