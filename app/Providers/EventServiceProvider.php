<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\ModelObserver;

use App\Models\MUser;
use App\Models\MQuiz;
use App\Models\MSetting;
use App\Models\MTest;
use App\Models\MTestMondai;
use App\Models\MTestQuiz;
use App\Models\TPurchase;
use App\Models\TRechargeHistory;
use App\Models\TTransaction;
use App\Models\TUserTestAnswer;
use App\Models\TUserTestScore;
use App\Models\UserCheckedIn;
use App\Models\MVideo;
use App\Models\MBunpo;
use App\Models\MUserBunpo;
use App\Models\MFeedback;
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        MUser::observe(ModelObserver::class);
        MQuiz::observe(ModelObserver::class);
        MSetting::observe(ModelObserver::class);
        MTest::observe(ModelObserver::class);
        MTestMondai::observe(ModelObserver::class);
        MTestQuiz::observe(ModelObserver::class);
        TPurchase::observe(ModelObserver::class);
        TRechargeHistory::observe(ModelObserver::class);
        TTransaction::observe(ModelObserver::class);
        TUserTestAnswer::observe(ModelObserver::class);
        TUserTestScore::observe(ModelObserver::class);
        UserCheckedIn::observe(ModelObserver::class);
        MVideo::observe(ModelObserver::class);
        MBunpo::observe(ModelObserver::class);
        MUserBunpo::observe(ModelObserver::class);
        MFeedback::observe(ModelObserver::class);
    }
}
