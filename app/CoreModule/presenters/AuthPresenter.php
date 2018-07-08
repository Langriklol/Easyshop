<?php
/**
 * Created by PhpStorm.
 * User: olangr
 * Date: 7/5/18
 * Time: 2:48 PM
 */

namespace App\CoreModule\Presenters;


use App\Forms\UserFormFactory;
use App\Presenters\BasePresenter;
use Nette\Utils\ArrayHash;

class AuthPresenter extends BasePresenter
{
    /** @var UserFormFactory */
    private $formFactory;
    /** @var array */
    private $instructions;

    public function __construct(UserFormFactory $formFactory)
    {
        parent::__construct();
        $this->formFactory = $formFactory;
    }

    public function startup()
    {
        parent::startup();
        $this->instructions = [
            'message' => null,
            'redirection' => ':Core:Auth:'
        ];
    }

    /**
     * @throws \Nette\Application\AbortException
     */
    public function actionLogin()
    {
        if ($this->getUser()->isLoggedIn())
            $this->redirect(':Core:Auth:');
    }

    /**
     * @throws \Nette\Application\AbortException
     */
    public function actionLogout()
    {
        $this->getUser()->logout();
        $this->redirect($this->loginPresenter);
    }

    /**
     * @throws \Nette\Application\AbortException
     */
    public function renderDefault()
    {
        $this->redirect(':Core:Product:list');
    }

    protected function createComponentLoginForm()
    {
        $this->instructions['message'] = 'You have been successfully signed in.';
        return $this->formFactory->createLoginForm(ArrayHash::from($this->instructions));
    }

    /**
     * @return mixed
     */
    protected function createComponentRegisterForm()
    {
        $this->instructions['message'] = 'You have been successfully signed up.';
        $form = $this->formFactory->createRegisterForm(ArrayHash::from($this->instructions));
        return $form;
    }
}