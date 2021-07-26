<?php


namespace App\Services;


abstract class StatusEnum
{
    const STATUS_PENDING = 'pending';
    const STATUS_FAIL = 'fail';
    const STATUS_SUCCESS = 'success';
    const STATUS_DECLINED = 'declined';
    const STATUS_ACCEPTED = 'accepted';
}
