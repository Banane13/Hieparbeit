<?php
namespace App\Controller\Frontend;

use App\Model\Blog\Blog;
use App\Model\Blog\BlogComment;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class BlogCommentController extends FrontendController
{
    public function showCommentFormAction(Request $request)
    {
        $this->setTemplateName('post-comment.form');
        $this->setRequest($request);

        $this->setPageTitle('Programm kommentieren');

        $blogId = intval($request->attributes->get('id'), 10);

        $blogComment = new BlogComment($this->getConfig(), $blogId);
        $blog = new Blog($this->getConfig());
        $formError = [];
        $formData = [];
        $data = $blog->loadSpecificEntry($blogId);
        if ($request->getMethod() !== 'POST') {
            // Set default values
            //$formData = array('title' => 'TEST12');
        } else {
            /* Check for errors */
            $formData = $this->getRequest()->request->all();
            $formError = $blogComment->checkErrors($formData);
        }
        // Handle valid post
        if ($request->getMethod() == 'POST' && count($formError) <= 0) {
            /* Save data */
            $formData['BId'] = $request->attributes->get('id');
            $blogComment->saveData($formData);

            return new RedirectResponse('/programm/' . $blogId);
        }
        return $this->getResponse(['data' => $data, 'formData' => $formData, 'errorData' => $formError]);
    }

}