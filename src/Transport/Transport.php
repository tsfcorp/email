<?php

namespace TsfCorp\Email\Transport;

use Exception;
use Mailgun\Mailgun;
use TsfCorp\Email\Models\EmailModel;

abstract class Transport
{
    /**
     * @var string|null
     */
    protected $remote_identifier;
    /**
     * @var string
     */
    protected $message;

    /**
     * @param \TsfCorp\Email\Models\EmailModel $email
     */
    abstract public function send(EmailModel $email);

    /**
     * @return string|null
     */
    public function getRemoteIdentifier()
    {
        return $this->remote_identifier;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Determine with which third party service this email should be sent
     *
     * @param \TsfCorp\Email\Models\EmailModel $email
     * @return \TsfCorp\Email\Transport\MailgunTransport
     * @throws \Exception
     */
    public static function resolveFor(EmailModel $email)
    {
        if ($email->provider == 'mailgun')
        {
            $mailgun = Mailgun::create(config('email.providers.mailgun.api_key'));

            return new MailgunTransport($mailgun);
        }

        throw new Exception('Invalid email provider');
    }
}