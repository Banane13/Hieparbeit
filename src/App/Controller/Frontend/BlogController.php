<?php
namespace App\Controller\Frontend;

use App\Model\Blog\Blog;
use App\Model\Blog\BlogComment;
use Symfony\Component\HttpFoundation\Request;


class BlogController extends FrontendController
{
    public function listAction()
    {
        $blog = new Blog($this->getConfig());

        $this->setTemplateName('blog-list');
        $this->setPageTitle('Programme');

        return $this->getResponse(['data' => $blog->loadData()]);
    }

    public function detailAction(Request $request)
    {
        $blog = new Blog($this->getConfig());
        $blogId = $request->attributes->get('id');

        $data = $blog->loadSpecificEntry($blogId);

        $blogComment = new BlogComment($this->getConfig(), $blogId);
        $commentData = $blogComment->getComment();

        $this->setTemplateName('blog-detail');
        $this->setPageTitle('Programmdetails');

        return $this->getResponse(['data' => $data, 'commentData' => $commentData]);
    }
}