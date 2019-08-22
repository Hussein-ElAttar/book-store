<?php

namespace App\Constants;

class ExceptionConstants
{
   // Token Exceptions code 1xxx
   const TOKEN_EXPIRED          = 1001;
   const TOKEN_INVALID          = 1002;
   const TOKEN_BLACKLISTED      = 1003;
   const TOKEN_BAD_REQUEST      = 1004;
   const TOKEN_USER_WAS_REMOVED = 1005;
   const TOKEN_NOT_PROVIDED     = 1006;

   // Resource Exceptions 2xxx
   const RESOURCE_NOT_FOUND = 2001;
   const RESOURCE_FORBIDDEN = 2002;

   // User Exceptions code 3xxx
   const USER_ALREADY_VERIFIED    = 3001;
   const USER_WRONG_EMAIL_OR_PASS = 3002;

   // Validation Exception code 4xxx
   const VALIDATION_INVALID_DATA = 4001;

/*----------------------------------------------------------------------------------------- */

   const MESSAGES = [
      // Token
      self::TOKEN_EXPIRED          => 'Token Expired',
      self::TOKEN_INVALID          => 'Token Invalid',
      self::TOKEN_BLACKLISTED      => 'Token Blacklisted',
      self::TOKEN_BAD_REQUEST      => 'Token Bad request',
      self::TOKEN_USER_WAS_REMOVED => 'Token User No Longer Exists',
      self::TOKEN_NOT_PROVIDED     => 'Token Not Provided',

      // Resource
      self::RESOURCE_NOT_FOUND => 'Resource Not Found',
      self::RESOURCE_FORBIDDEN => 'You cannot use this Resource',

      // User
      self::USER_ALREADY_VERIFIED    => 'User has already been activated',
      self::USER_WRONG_EMAIL_OR_PASS => 'Wrong email or passwor',

      // Validation
      self::VALIDATION_INVALID_DATA =>'The given data is invalid',
   ];

/*----------------------------------------------------------------------------------------- */

   const HTTP_CODES = [
      // Token
      self::TOKEN_EXPIRED          => 401,
      self::TOKEN_INVALID          => 401,
      self::TOKEN_BLACKLISTED      => 401,
      self::TOKEN_BAD_REQUEST      => 400,
      self::TOKEN_USER_WAS_REMOVED => 400,
      self::TOKEN_NOT_PROVIDED     => 401,

      // Resource
      self::RESOURCE_NOT_FOUND => 401,
      self::RESOURCE_FORBIDDEN => 401,

      // User
      self::USER_ALREADY_VERIFIED    => 400,
      self::USER_WRONG_EMAIL_OR_PASS => 401,

      // Validation
      self::VALIDATION_INVALID_DATA => 422,
   ];

}