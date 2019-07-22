<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
	    if ($this->app->environment('local', 'testing')) {
		    //$this->app->register(DuskServiceProvider::class);
	    }
	    if (env('APP_ENV') === 'production') {
		    //URL::forceSchema('https');
	    }
//	    URL::forceScheme('https');
	    Blade::directive('serverRender', function ($view) {
		    $target_id = 'I' . rand(0, 99999999);
		    return '<span id="' . $target_id . '">Not Loaded</span>
			<script>
				$(document).ready(function () {
					$.ajax({
						url: "' . route('eac.ajax.page') . '",
						data: { id: "'. '<?=$drug->id?>' .'", view: "'. trim($view, "'") .'"},
					}).done(function (response) {
						$("#' . $target_id . '").html(response);
					});
				});
			</script>';
	    });
	    Blade::directive('access', function ($expression) {
		    $params = explode(",", $expression);
		    $str = '<?php if($access->gate(' . $expression . ')): ?>';
		    return $str;
	    });
	    Blade::directive('elseaccess', function ($expression) {
		    $params = explode(",", $expression);
		    $str = '<?php elseif($access->gate(' . $expression . ')): ?>';
		    return $str;
	    });
	    Blade::directive('endaccess', function () {
		    $str = '<?php endif; ?>';
		    return $str;
	    });
	    Blade::directive('GetTab', function () {
		    return "<?php echo session('pageActiveSection'); ?>";
	    });
	    Blade::directive('SetTab', function ($expression) {
		    return "<?php session(['pageActiveSection' => {$expression}]); ?>";
	    });
	    Blade::directive('IndexTab', function ($expression) {
		    return "<?php if(session('pageActiveSection') == {$expression}) echo 'active'; ?>";
	    });

	    Carbon::serializeUsing(function ($carbon) {
		    return $carbon->format(config('eac.date_format'));
	    });
    }
}
