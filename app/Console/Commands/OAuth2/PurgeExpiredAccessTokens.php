<?php


namespace App\Console\Commands\OAuth2;


use Illuminate\Console\Command;
use Laravel\Passport\Token;

class PurgeExpiredAccessTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oauth:purge-access-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge Oauth2 Access Tokens';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Token::query()->where('expires_at', '<', now())->delete();
    }
}
