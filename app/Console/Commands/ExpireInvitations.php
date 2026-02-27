<?php

namespace App\Console\Commands;

use App\Models\Invitation;
use Illuminate\Console\Command;

use function Symfony\Component\Clock\now;

class ExpireInvitations extends Command
{

    protected $signature = 'app:expire-invitations';

    protected $description = 'Command description';

    public function handle()
    {
        Invitation::where('status','pending')
        ->whereNotNull('expire_at')
        ->where('expire_at' , '<=', now())
        ->update(['status' => 'expired']);
        return self::SUCCESS;
    }
}
