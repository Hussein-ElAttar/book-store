<?php

namespace App\Constants;

class ResponseMessageConstants
{

   // Book Messages
   const BOOK_DELETED = "Book Deleted Successfully";
   const BOOK_UPDATED = "Book Updated Successfully";

   // User Messages
   const USER_RESET_PASSWORD_EMAIL_SENT = "We have e-mailed your password reset link";
   const USER_ACTIVITON_LINK_EMAIL_SENT = "Your Activation link has been sent to your email";
   const USER_PASSWORD_RESET            = "Your password was rest successfully";
   const USER_EMAIL_ACTIVATED           = "Email verified!";

   // Token Messages
   const TOKEN_REFRESHED   = "Token refresh successfully, check response authorization header";
   const TOKEN_INVALIDATED = "Token invalidated successfully";
}