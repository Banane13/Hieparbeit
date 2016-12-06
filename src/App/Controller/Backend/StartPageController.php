<?php
namespace App\Controller\Backend;

use App\Model\BackendUser\BackendUser;
use Symfony\Component\HttpFoundation\RedirectResponse;

class StartPageController extends BackendController
{
    public function indexAction()
    {
        $login = $this->checkLogin();
        if ($login instanceof RedirectResponse) {
            return $login;
        }

        $user = new BackendUser($this->getConfig());
        $userData = $user->getUserById($this->getUserId());

        $this->setTemplateName('start-page');
        $this->setPageTitle('Übersicht');

        return $this->getResponse(['user' => $userData]);
    }
}