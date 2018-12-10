# Library for sending emails - Laravel
 
Fluent interface for composing and sending emails

This package was designed to work in a standalone project or in a cluster of projects which push messages into a master project/database which act as a collector.

If you use this package in cluster mode, make sure the process `php artisan emails:dispatch-jobs` is running on master project. This can be kept alive with `supervisor`

# Installation

Require this package in your `composer.json` and update composer. Run the following command:
```php
composer require tsfcorp/email
```

After updating composer, the service provider will automatically be registered and enabled using Auto-Discovery

If your Laravel version is less than 5.5, make sure you add the service provider within `app.php` config file.

```php
'providers' => [
    // ...
    TsfCorp\Email\EmailServiceProvider::class,
];
```

Next step is to run the artisan command to install config file and optionally migration file. The command will guide you through the process.

```php
php artisan email:install
```

Update `config/email.php` with your settings.
### Requirements
This package makes use of Laravel Queues/Jobs to send emails. Make sure the queue system is configured properly

# Usage Instructions

```php
use TsfCorp\Email\Email;

$email = (new Email())
    ->to('to@mail.com')
    ->cc('cc@mail.com')
    ->bcc('bcc@mail.com')
    ->subject('Hi')
    ->body('Hi there!');
``` 
Use `enqueue()` method to save the message in database without sending. Useful when you want to just save the message but delay sending. Or when `database_connection` config value is another database and sending is performed from there.

```php
$email->enqueue();
```

Save the message and schedule a job to send the email
```php
$email->enqueue()->dispatch();
```

#Email Providers
Currently all emails are sent with Mailgun. More to come...

#Webhooks
If an email could not be sent to a recipient, the email provider can notify you about this. This package handles permanent failures webhooks for you. 

#### Mailgun
Add `http://app.example/webhook-mailgun` link to "Permanent Failure" section within you mailgun webhooks settings