<?php

namespace App\Domains\Auth\Forms;

use App\Infra\Repository\User\UserRepository;
use Yii;
use App\Domains\User\User;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Login extends Model
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var boolean
     */
    public $rememberMe = true;

    /**
     * @var User|null
     */
    private $user = null;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function init()
    {
        $this->userRepository = Yii::$container->get(UserRepository::class);
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'password' => 'Senha',
            'rememberMe' => 'Lembrar-me neste PC'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if ($this->hasErrors()) {
            return;
        }

        $user = $this->getUser();

        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError($attribute, 'E-mail e/ou Senha inválidos');
        }
    }

    /**
     * Logs in a user using the provided email and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }

        return false;
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if (is_null($this->user)) {
            $this->user = $this->userRepository->findByEmail($this->email);
        }

        return $this->user;
    }
}
