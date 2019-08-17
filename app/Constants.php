<?php

namespace App;

class Constants {
   const EMAIL_VALIDATION_URL_TTL_MINUTES = 60;

   // Exception Codes

   // Http Codes
   const HTTP_SUCCESS      = 200;
   const HTTP_BAD_REQUEST  = 400;
   const HTTP_UNAUTHORIZED = 401;
   const HTTP_FORBIDDEN    = 403;

   // Book Messages
   const MSG_BOOK_DELETED   = "Book Deleted Successfully";
   const MSG_BOOK_UPDATED   = "Book Updated Successfully";
   const MSG_BOOK_NOT_FOUND = "Book Not Found";
   const MSG_BOOK_FORBIDDEN = "You cannot use this book";

   // User Messages
   const MSG_USER_RESET_PASSWORD_EMAIL_SENT = "We have e-mailed your password reset link";
   const MSG_USER_ACTIVITON_LINK_SUBMITTED  = "Your Activation link has been submitted";
   const MSG_USER_PASSWORD_RESET  = "Your password was rest successfully";
   const MSG_USER_EMAIL_ACTIVATED = "Email verified!";
   const MSG_USER_ALREADY_VERIFIED = "User already has verified email!";
}