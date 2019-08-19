<?php

namespace App\Constants;

class ExceptionConstants
{
   const RESOURCE_NOT_FOUND = ['Resource Not Found', 404];
   const RESOURCE_FORBIDDEN = ['You cannot use this Resource', 403];

   // JWT
   const TOKEN_EXPIRED          = ['Token Expired', 401];
   const TOKEN_INVALID          = ['Token Invalid', 401];
   const TOKEN_BLACKLISTED      = ['Token Blacklisted', 401];
   const TOKEN_BAD_REQUEST      = ['Token Bad request', 400];
   const TOKEN_USER_WAS_REMOVED = ['User No Longer Exists', 400];

}