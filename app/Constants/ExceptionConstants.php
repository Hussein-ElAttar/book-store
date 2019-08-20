<?php

namespace App\Constants;

class ExceptionConstants
{
   const RESOURCE_NOT_FOUND = ['Resource Not Found', 404];
   const RESOURCE_FORBIDDEN = ['You cannot use this Resource', 403];

   // User
   const USER_ALREADY_VERIFIED = "User has already been activated";

   // JWT
   const TOKEN_EXPIRED          = ['Token Expired', 401];
   const TOKEN_INVALID          = ['Token Invalid', 401];
   const TOKEN_BLACKLISTED      = ['Token Blacklisted', 401];
   const TOKEN_BAD_REQUEST      = ['Token Bad request', 400];
   const TOKEN_USER_WAS_REMOVED = ['User No Longer Exists', 400];

   // Validation
   const VALIDATION_INVALID_DATA = ['The given data is invalid', 422];
}