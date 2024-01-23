<?php

namespace App\Helper;

use App\Models\Client;
use App\Models\User;

class Helper
{
    static function Clients()
    {
        $clientsetting = Client::where('user_id', auth()->user()->id)->first();
        return $clientsetting;
    }

    static function Users()
    {
        $usersetting = User::find(auth()->user()->id);
        return $usersetting;
    }
}
