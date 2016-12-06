<?php

namespace App\Controller\Frontend;

class NotFoundController extends FrontendController
{

    public function notFoundAction()
    {
        $this->setTemplateName('404');
        $this->setPageTitle('Nichts gefunden');

        return $this->getResponse();
    }
}