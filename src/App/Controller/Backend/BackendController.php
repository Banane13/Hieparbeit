<?php
namespace App\Controller\Backend;

use App\Controller\Controller;
use App\Helper\Session;
use App\Model\BackendUser\BackendUser;
use Symfony\Component\HttpFoundation\RedirectResponse;

abstract class BackendController extends Controller
{
    protected $path = '/../../../templates/backend/';

    private $userId = null;

    protected $loggedIn = false;

    protected function setLoggedIn()
    {
        $this->loggedIn = true;
    }

    protected function setLoggedOut()
    {
        $this->loggedIn = false;
    }

    protected function getUserId()
    {
        return $this->userId;
    }

    protected function setContentData($data = [])
    {
        parent::setContentData($data);
        $this->contentData = array_merge($this->contentData, array('loggedIn' => $this->loggedIn));
    }

    protected function checkLogin()
    {
        $this->userId = Session::getSessionByKey(BackendUser::getSessionName());
        if ($this->getUserId() == false) {
            $this->setLoggedOut();
            Session::removeSession();
            return new RedirectResponse('/admin');
        }
        $this->setLoggedIn();
        return true;
    }
}