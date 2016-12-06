<?php
namespace App\Controller\Backend;

use Symfony\Component\HttpFoundation\RedirectResponse;

class BackendUserController extends BackendController
{
    public function indexAction()
    {
        $login = $this->checkLogin();
        if ($login instanceof RedirectResponse) {
            return $login;
        }

        $this->setTemplateName('backend-user-list');
        $this->setPageTitle('Nutzer');

        return $this->getResponse();
    }

}