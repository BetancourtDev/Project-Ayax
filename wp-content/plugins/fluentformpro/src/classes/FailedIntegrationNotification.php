<?php

namespace FluentFormPro\classes;


use FluentForm\Framework\Helpers\ArrayHelper;

if ( ! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


/**
 * Trigger Email Notification when integration fails to run
 */
class FailedIntegrationNotification
{
    private $key = '_fluentform_failed_integration_notification';

    /**
     * Registers actions
     */
    public function init()
    {
        add_action('fluentform/saving_global_settings_with_key_method', [$this, 'saveEmailConfig'], 10, 1);
      
        add_action('fluentform/integration_action_result', [$this, 'sendEmail'], 10, 3);
    }

    /**
     * Send Email if status is failed
     *
     * @param $feed
     * @param $status
     * @param $message
     *
     * @return void
     */
    public function sendEmail($feed, $status, $message)
    {
        if (!$this->isEnabled() || $status != 'failed') {
            return;
        }

        $settings = $this->getEmailConfig();

        $feedData = wpFluent()->table('ff_scheduled_actions')
                              ->where('feed_id', $feed['id'])
                              ->get();
        $feedData = array_pop($feedData);
        if (empty($feedData)) {
            return;
        }

        if ($settings['send_to_type'] == 'admin_email') {
            $email = get_option('admin_email');
        } else {
            $email = $settings['custom_recipients'];
        }
        
        $feedDataSettings = unserialize($feedData->data);
        
        $integrationName = isset($feedDataSettings['settings']['name']) ?
            $feedDataSettings['settings']['name']
            : ucwords(str_replace('_', ' ', $feedDataSettings['meta_key']));
    
        $sub = sprintf(
            "%s - Form ID : %s - Entry ID : %s: %s Failed to Run",
            get_bloginfo('name'),
            $feedData->form_id,
            $feedData->origin_id,
            $integrationName
        );

        $emails = $this->getSendAddresses($email);
        if ( ! $emails) {
            return;
        }
        $data = [
            'email'   => $emails,
            'subject' => $sub,
            'body'    => ! empty($message) ? $message : 'Integration Failed to Run, please check your cronjob status.'
        ];
    
        $entryLink = admin_url('admin.php?page=fluent_forms&route=entries&form_id=' . $feedData->form_id . '#/entries/' . $feedData->origin_id);
        
        $data['body'] .= " <br /> <br /> <a href='{$entryLink}'>View Submission</a>";

        $this->broadCast($data);
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        $settings = $this->getEmailConfig();

        return $settings['status'] == 'yes';
    }

    /**
     * @return false|mixed|string[]|void
     */
    public function getEmailConfig()
    {
        $settings = [
            'status'            => 'yes',
            'send_to_type'      => 'admin_email',
            'custom_recipients' => '',
        ];
        if (get_option($this->key)) {
            $settings = get_option($this->key);
        }

        return $settings;
    }

    /**
     * @param $request
     *
     * @return void
     */
    public function saveEmailConfig($request)
    {
        if (ArrayHelper::get($request,'key') != 'failedIntegrationNotification') {
            return;
        }
        $defaults = [
            'status'            => 'yes',
            'send_to_type'      => 'admin_email',
            'custom_recipients' => '',
        ];
        $settings = ArrayHelper::get($request,'value');
        $settings = json_decode($settings, true);

        $settings = wp_parse_args($settings, $defaults);

        update_option($this->key, $settings, false);

        wp_send_json_success(true);
    }

    /**
     * @param $data
     *
     * @return bool|mixed|void
     */
    private function broadCast($data)
    {
        $headers = [
            'Content-Type: text/html; charset=utf-8'
        ];
        $data = apply_filters_deprecated(
            'ff_failed_integration_notify_email_data',
            [
                $data
            ],
            FLUENTFORM_FRAMEWORK_UPGRADE,
            'fluentform/failed_integration_notify_email_data',
            'Use fluentform/failed_integration_notify_email_data instead of ff_failed_integration_notify_email_data.'
        );
        $data = apply_filters('fluentform/failed_integration_notify_email_data', $data);

        return wp_mail(
            $data['email'],
            $data['subject'],
            $data['body'],
            $headers,
            ''
        );
    }

    /**
     * Get Send Email Addresses
     *
     * @param $email
     *
     * @return array
     */
    private function getSendAddresses($email)
    {
        $sendEmail = explode(',', $email);
        if (count($sendEmail) > 1) {
            $email = $sendEmail;
        } else {
            $email = [$email];
        }

        return array_filter($email, 'is_email');
    }


}
