<?php

namespace App\Controller\Frontend;

class StartPageController extends FrontendController
{
    public function indexAction()
    {
        $this->setTemplateName('start-page');
        $this->setPageTitle('Tickets');

        return $this->getResponse();
    }
}