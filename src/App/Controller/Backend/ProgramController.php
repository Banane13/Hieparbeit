<?php
namespace App\Controller\Backend;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class ProgramController extends BackendController
{
    public function indexAction()
    {
        $login = $this->checkLogin();
        if ($login instanceof RedirectResponse) {
            return $login;
        }

        $this->setTemplateName('program-list');
        $this->setPageTitle('Programme');

       // $program = new Program($this->getConfig());
       // $programData = $program->loadData();

        return $this->getResponse([
         //   'programData' => $programData
        ]);
    }

    public function editAction(Request $request)
    {
        $login = $this->checkLogin();
        if ($login instanceof RedirectResponse) {
            return $login;
        }

        $id = $request->attributes->get('id');

        $this->setTemplateName('program-edit');
        $this->setPageTitle('Programm bearbeiten');

        //$program = new Program($this->getConfig());
        //$programData = $program->loadSpecificEntry($id);

        return $this->getResponse([
           // 'formData' => $programData
        ]);
    }

}