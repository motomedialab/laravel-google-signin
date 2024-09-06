<?php

namespace Motomedialab\GoogleSignin\Enums;

use ReflectionEnum;
use Motomedialab\GoogleSignin\Attributes\ErrorDetails;

enum DenialReason: string
{
    #[ErrorDetails('The state parameter did not match the expected value.', 400)]
    case InvalidState = 'invalid_state';

    #[ErrorDetails('The email address provided by Google did not match any existing user.', 401)]
    case EmailNotFound = 'email_not_found';

    #[ErrorDetails('The email address provided by Google is already associated with a different Google ID.', 403)]
    case GoogleIdMismatch = 'google_id_mismatch';

    public function getDescription(): ?string
    {
        return $this->getErrorDetailsAttribute()?->description;
    }

    public function getStatusCode(): ?int
    {
        return $this->getErrorDetailsAttribute()?->status;
    }

    private function getErrorDetailsAttribute(): ?ErrorDetails
    {
        return once(function () {
            try {
                $reflection = new ReflectionEnum($this);
                $attributes = $reflection->getCase($this->name)->getAttributes(ErrorDetails::class);
            } catch (\ReflectionException) {
                return null;
            }

            return ($attributes[0] ?? null)?->newInstance();
        });
    }
}
