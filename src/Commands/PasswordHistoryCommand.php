<?php

namespace Starfolksoftware\PasswordHistory\Commands;

use Illuminate\Console\Command;

class PasswordHistoryCommand extends Command
{
    public $signature = 'password-history';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
