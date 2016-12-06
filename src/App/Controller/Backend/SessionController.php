<?php

namespace App\Controller\Backend;


use App\Helper\Session;
use App\Model\BackendUser\BackendUser;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class SessionController extends BackendController
{
    public function loginAction(Request $request)
    {
        $this->setTemplateName('login');
        $this->setPageTitle('Login');

        $this->setRequest($request);

        $backendUser = new BackendUser($this->getConfig());
        $formError = [];
        $formData = [];
        if ($request->getMethod() !== 'POST') {
            // Set default values
            //$formData = array('title' => 'TEST12');
        } else {
            /* Check for errors */
            $formData = $this->getRequest()->request->all();
            $formError = $backendUser->checkErrors($formData);
        }
        // Handle valid post
        if ($request->getMethod() == 'POST' && count($formError) <= 0) {
            /* Save data */
            //$formData['BId'] = $request->attributes->get('id');
            //$backendUser->saveData($formData);
            $this->setLoggedIn();
            return new RedirectResponse('/admin/start');
        }
        return $this->getResponse(['formData' => $formData, 'formError' => $formError]);
    }

    public function logoutAction()
    {
        $this->setLoggedOut();
        Session::removeSession();
        return new RedirectResponse('/admin');
    }
}