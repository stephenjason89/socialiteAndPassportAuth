<?php


namespace App\Console\Commands\OAuth2;


use Illuminate\Console\Command;
use Laravel\Passport\RefreshToken;

class PurgeExpiredRefreshTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oauth:purge-refresh-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge Oauth2 Refresh Tokens';

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
        RefreshToken::query()->where('expires_at', '<', now())->delete();
    }
}
