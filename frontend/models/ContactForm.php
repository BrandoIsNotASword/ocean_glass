<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $lastName;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name','lastName','email','body'], 'required','message'=>"Campo <strong>{attribute}</strong> es obligatorio"],
            // email has to be a valid email address
            ['email', 'email','message'=>"El <strong>Email</strong> no es valido"],
            // verifyCode needs to be entered correctly
            ['email','googleCaptcha'],
        ];
    }
    public function googleCaptcha($model,$attribute)
    {
        $recaptcha = new \ReCaptcha\ReCaptcha("6Len9QgTAAAAAMkr75Dtibe_uhWGnXRaKZzS3qmy");
        $resp = $recaptcha->verify($_POST['g-recaptcha-response'],$_SERVER['REMOTE_ADDR']);
        if (!$resp->isSuccess()) {
            $this->addError("email",'Has Click en <strong>"No soy un robot"</strong>');
        }
        // $errors = $resp->getErrorCodes();
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Codigo de Verificacion',
            'name' => 'Nombre',
            'lastName' => 'Apellido',
            'email' => 'E-mail',
            'body' => 'Mensaje',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name.' '.$this->lastName])
            ->setSubject("Contacto La Gran Nación")
            ->setTextBody($this->body)
            ->send();
    }
}
