<?php
namespace frontend\models;

use common\models\Client;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $password;
    public $rememberMe = true;
    public $comparePassword;
    public $compareEmail;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstName','lastName','email','password'],'required','message'=>"Campo obligatorio"],
            ['email','email','message'=>'El {attribute} no es valido'],
            ['email', 'unique','targetClass'=>'common\models\Client','targetAttribute'=>'email','message'=>"Correo electronico ya registrado"],
            ['email','compare','operator'=>'===','compareAttribute'=>'compareEmail','message'=>'Correo Electrónico no coincide'],
            ['password','compare','operator'=>'===','compareAttribute'=>'comparePassword','message'=>'¡Las Contraseñas no coinciden!'],
            ['rememberMe', 'boolean'],
            [['comparePassword','compareEmail','phone'],'safe'],

        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $client = new Client();
            $client->firstName = $this->firstName;
            $client->lastName = $this->lastName;
            $client->email = $this->email;
            $client->compareEmail = $this->compareEmail;
            $client->phone = $this->phone;
            $client->password_hash = $this->password;
            $client->comparePassword = $this->password;
            $client->status = Client::StatusActive;
            $client->generateAuthKey();
            if($client->save()){
                return $client;
            }
        }

        return null;
    }
}
