<?php

namespace App\Enums;

enum SubscriberStatus: string
{
    case Active = 'active';
    case Unsubscribed = 'unsubscribed';
    case Junk = 'junk';
    case Bounced = 'bounced';
    case Unconfirmed = 'unconfirmed';

}
