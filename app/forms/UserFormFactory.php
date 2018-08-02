<?php

namespace App\Forms;

use App\Model\DuplicateNameException;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use Nette\Security\User;
use Nette\Utils\ArrayHash;

/**
 * Created by PhpStorm.
 * User: lango
 * Date: 5/22/18
 * Time: 11:09 PM
 */

class UserFormFactory
{
    /** @var User $user */
    private $user;

    /** @param User $user */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param Form $form
     * @param null|ArrayHash $instructions
     * @param bool $register
     * @throws \Nette\Application\AbortException
     */
    private function login(Form $form, ArrayHash $instructions = null, bool $register = false)
    {
        $presenter = $form->getPresenter();
        try{
            $username = $form->getValues()->email;
            $password = $form->getValues()->password;

            if ($register)
                $this->user->getAuthenticator()->register($username, $password);

            $this->user->login($username, $password);
            if ($instructions && $presenter) {
                if (isset($instructions->message))
                    $presenter->flashMessage($instructions->message);

                if (isset($instructions->redirection))
                    $presenter->redirect($instructions->redirection);
            }

        }catch (AuthenticationException $e){
            if ($presenter) {//if form is in presenter send error message to presenter
                $presenter->flashMessage($e->getMessage());
                $presenter->redirect('this'); // redirect
            } else {
                $form->addError($e->getMessage()); // else throw an error
            }
        }
    }

    /** @param Form $form
     * @return Form
     */
    public function createBasicForm(Form $form = null)
    {
        $form = $form ? $form : new Form();
        $form->addText('email', 'Email')
            ->addRule(Form::EMAIL, 'Invalid email format')
            ->setRequired();
        $form->addPassword('password', 'Heslo')
            ->setRequired();
        return $form;
    }

    /**
     * @param null $instructions
     * @param Form|null $form
     * @return Form
     */
    public function createLoginForm($instructions = null, Form $form = null)
    {
        $form = $this->createBasicForm($form);
        $form->addSubmit('submit', 'Sign in');
        $form->onSuccess[] = function (Form $form) use ($instructions){
            $this->login($form, $instructions);
        };
        return $form;
    }

    /**
     * @param ArrayHash|null $instructions
     * @param Form|null $form
     * @return Form
     */
    public function createRegisterForm(ArrayHash $instructions = null, Form $form = null)
    {
        $form = $this->createBasicForm($form);
        $form->addPassword('password_repeat', 'Repeat password')
            ->addRule(Form::EQUAL, 'Passwords does not match.', $form['password'])
            ->setRequired();
        $form->addSubmit('register', 'Sign up');
        $form->onSuccess[] = function (Form $form) use ($instructions) {
            try {
                $this->login($form, $instructions, true);
            }catch(DuplicateNameException $e){
                $form->addError($e->getMessage());
            }
        };
        $form->onError[] = ["Bad email or password"];
        return $form;
    }
}