<?php

namespace App\Constants;

class ExceptionConstants
{
   const RESOURCE_NOT_FOUND = ["Resource Not Found", 404];
   const RESOURCE_FORBIDDEN = ["You cannot use this Resource", 403];

   // User Messages
   const USER_RESET_PASSWORD_EMAIL_SENT = ["We have e-mailed your password reset link", 200];
   const USER_ACTIVITON_LINK_SUBMITTED  = ["Your Activation link has been submitted", 200];
   const USER_PASSWORD_RESET  = ["Your password was rest successfully", 200];
   const USER_EMAIL_ACTIVATED = ["Email verified", 200];
   const USER_ALREADY_VERIFIED = ["User already has verified email", 422];
}