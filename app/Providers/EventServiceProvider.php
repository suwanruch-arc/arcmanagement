<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

        Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
            if (preg_match('/\b(insert|update|delete)\s/', $query->sql)) {
                $sql = str_replace("?", "%s", $query->sql);
                $bindings = array_map(function ($binding) {
                    if (is_int($binding)) {
                        return $binding;
                    } elseif (is_null($binding)) {
                        return 'NULL';
                    } elseif (is_bool($binding)) {
                        return $binding ? 1 : 0;
                    } else {
                        $binding = addcslashes($binding, "'\"");
                        return "'$binding'";
                    }
                }, $query->bindings);

                $date = date('Ymd');
                $userID = Auth::id();
                $statement = vsprintf($sql, $bindings);
                $encryptedQueries = Crypt::encrypt("UserID:{$userID}|{$statement}");
                Log::build([
                    'driver' => 'single',
                    'path' => storage_path("logs/sql/{$date}.log"),
                ])->info($encryptedQueries);
            }
        });
    }
}
