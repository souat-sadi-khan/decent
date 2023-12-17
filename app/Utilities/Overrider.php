<?php

namespace App\Utilities;

class Overrider
{

    public static function load($type)
    {
        $method = 'load' . ucfirst($type);

        static::$method();
    }

    protected static function loadSettings()
    {
        // Timezone
        config(['app.timezone' => get_option('timezone')]);

        // Email
        $email_protocol = get_option('set_mail_driver');
        config(['mail.driver' => $email_protocol]);
        config(['mail.from.name' => get_option('mail_from_name')]);
        config(['mail.from.address' => get_option('mail_from_address')]);

        if ($email_protocol == 'smtp') {
            config(['mail.host' => get_option('smtp_host')]);
            config(['mail.port' => get_option('smtp_port')]);
            config(['mail.username' => get_option('smtp_username')]);
            config(['mail.password' => get_option('smtp_password')]);
            config(['mail.encryption' => get_option('smtp_encryption')]);
        }
        if ($email_protocol == 'mailgun') {
            config(['mail.host' => get_option('mailgun_host')]);
            config(['mail.port' => get_option('mailgun_port')]);
            config(['mail.username' => get_option('mailgun_username')]);
            config(['mail.password' => get_option('mailgun_password')]);
            config(['mail.encryption' => get_option('mailgun_encryption')]);
        }
		
    }

}