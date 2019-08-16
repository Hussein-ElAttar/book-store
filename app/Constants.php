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
   const BOOK_DELETED   = "Book Deleted Successfully";
   const BOOK_UPDATED   = "Book Updated Successfully";
   const BOOK_NOT_FOUND = "Book Not Found";
   const BOOK_FORBIDDEN = "You cannot use this book";

   // User Messages
   const USER_RESET_PASSWORD_EMAIL_SENT = "We have e-mailed your password reset link";
   const USER_ACTIVITON_LINK_SUBMITTED  = "Your Activation link has been submitted";
   const USER_PASSWORD_RESET  = "Your password was rest successfully";
   const USER_EMAIL_ACTIVATED = "Email verified!";
   const USER_ALREADY_VERIFIED = "User already has verified email!";
}