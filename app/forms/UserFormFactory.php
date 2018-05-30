<?php

namespace App\Forms;

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
    private $user;

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
            $username = $form->getValues()->username;
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

    public function createBasicForm(Form $form = null)
    {
        $form = $form ? $form : new Form();
        $form->addText('nickname', 'Jméno')
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
        $form->addSubmit('submit', 'Přihlásit');
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
        $form->addPassword('password_repeat', 'Zopakujde heslo')
            ->addRule(Form::EQUAL, 'Hesla se neshodují.', $form['password'])
            ->setRequired();
        $form->addSubmit('register', 'Sign up');
        $form->onSuccess[] = function (Form $form) use ($instructions) {
            $this->login($form, $instructions, true);
        };
        return $form;
    }
}