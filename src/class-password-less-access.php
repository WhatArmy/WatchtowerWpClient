<?php
/**
 * Author: Code2Prog
 * Date: 2019-06-10
 * Time: 18:49
 */

namespace WhatArmy\Watchtower;

/**
 * Class Password_Less_Access
 * @package WhatArmy\Watchtower
 */
class Password_Less_Access
{
    /**
     * @return array
     */
    public function generate_ota()
    {
        $ota_token = 'ota_'.md5(uniqid());
        update_option('watchtower_ota_token', $ota_token);

        return array(
            'ota_token' => $ota_token,
            'admin_url' => admin_url(),
        );
    }


    public function login()
    {
        $random_password = wp_generate_password(30);

        $admins_list = get_users('role=administrator&search='.WHT_CLIENT_USER_EMAIL);
        if ($admins_list) {
            reset($admins_list);
            $adm_id = current($admins_list)->ID;
            wp_set_password($random_password, $adm_id);
        } else {
            $adm_id = wp_create_user(WHT_CLIENT_USER_NAME, $random_password, WHT_CLIENT_USER_EMAIL);
            $wp_user_object = new \WP_User($adm_id);
            $wp_user_object->set_role('administrator');
        }

        wp_clear_auth_cookie();
        wp_set_current_user($adm_id);
        wp_set_auth_cookie($adm_id);

        $redirect_to = user_admin_url();
        update_option('watchtower_ota_token', 'not_set');
        wp_safe_redirect($redirect_to);
        exit();
    }
}