<?php

namespace App\Controller;

use App\Model\Post;
use Nester\Application;
use Nester\Controller;
use Nester\DI\Container;
use Nester\Http\RedirectResponse;
use Nester\Http\Request;

class CrudController extends Controller
{
    /**
     * Posts model.
     *
     * @var Post
     */
    private $postModel;

    public function __construct(Post $postModel, Application $app, Container $di)
    {
        $this->postModel = $postModel;
        parent::__construct($app, $di);
    }


    public function main(Request $request)
    {

        return $this->render('list.php', [
            'posts' => $this->postModel->findAll()
        ]);
    }

    public function create()
    {
        return $this->render('form.php');
    }

    public function saveNew(Request $request)
    {
        $this->postModel->setAttributes([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
        ]);

        $this->postModel->insert();
        return new RedirectResponse($this->app->getConfig()['basePath'] . '/');
    }

    public function edit(Request $request)
    {
        return $this->render('form.php', [
            'post' => $this->postModel->findById($request->get('id'))
        ]);
    }

    public function saveExisting(Request $request)
    {
        $this->postModel->setAttributes([
            'id' => $request->get('id'),
            'title' => $request->get('title'),
            'body' => $request->get('body'),
        ]);

        $this->postModel->update();
        return new RedirectResponse($this->app->getConfig()['basePath'] . '/');
    }

    public function delete(Request $request)
    {
        $this->postModel->deleteById($request->get('id'));
        return new RedirectResponse($this->app->getConfig()['basePath'] . '/');
    }
}
