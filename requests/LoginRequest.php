<?php 
namespace app\requests;

use app\core\Request;

/**
 * Class LoginRequest
 *
 * Handles the validation of login requests.
 */

class LoginRequest extends Request
{
    /**
     * Returns the rules for the login request.
     *
     * @return array The rules for the login request.
     */
    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    /**
     * Returns the attributes for the login request.
     *
     * @return array The attributes for the login request.
     */
    public function labels(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Password'
        ];
    }
}