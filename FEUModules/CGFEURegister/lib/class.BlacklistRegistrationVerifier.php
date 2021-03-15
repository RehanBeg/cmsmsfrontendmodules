<?php
namespace CGFEURegister;
use CGFEURegister;

class BlacklistRegistrationVerifier
    extends AbstractVerifierDecorator
    implements RegistrationVerifierInterface
{
    private $settings;

    public function __construct(RegistrationVerifierInterface $parent, Settings $settings)
    {
        parent::__construct($parent);
        $this->settings = $settings;
    }

    protected function match_username_from_string(string $list, string $username) : bool
    {
        $list = preg_split("/((\r(?!\n))|((?<!\r)\n)|(\r\n))/", $list);
        if (count($list)) {
            foreach ($list as $one_line) {
                $regex = '/^' . str_replace("@", "\@", str_replace("\*", ".*", preg_quote($one_line))) . '$/';
                if (preg_match($regex, $username) > 0) return true;
            }
        }
        return true;
    }

    public function validate_pure_registration(RegFieldSet $fields, User $user)
    {
        // because the interface says we have to have this method
        return $this->parent->validate_pure_registration($fields, $user);
    }

    public function validate_registration(RegFieldSet $fields, User $user)
    {
        // check if we have blacklist stuff
        $matches_blacklist = $matches_whitelist = null;
        if( $this->settings->username_blacklist ) {
            $matches_blacklist = $this->match_username_from_string($this->settings->username_blacklist, $user->username);
        }
        if( $this->settings->username_whitelist ) {
            $matches_whitelist = $this->match_username_from_string($this->settings->username_whitelist, $user->username);
        }

        if( $this->settings->username_blacklist ) {
            if( !$matches_blacklist && !$matches_whitelist ) {
                // failed valid blacklist, not excluded in whitelist.
                throw new ValidationError($this->mod->Lang('err_username_cannotregister'));
            }
        }
        else if( $this->settings->username_whitelist && !$matches_whitelist ) {
            // no blacklist, have whitelist and does not match whitelist.
            throw new ValidationError($this->mod->Lang('err_username_cannotregister'));
        }

        return $this->parent->validate_registration($fields, $user);
    }
} // class