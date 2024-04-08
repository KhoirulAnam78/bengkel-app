<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\AuthenticateUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        
        // Fortify::authenticateUsing(function (Request $request) {
        //     dd($request);
        //     return $request;
        // });
        // Fortify::authenticateUsing([ new AuthenticateUser,'authenticate']);
        
        
        RateLimiter::for('login', function (Request $request) {
            $username = (string) $request->username;

            return Limit::perMinute(5)->by($username . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // Login
        Fortify::loginView(fn () => view('auth.login'));

        // Register
        Fortify::registerView(fn () => view('auth.register'));

         // Verify Email
        Fortify::verifyEmailView(fn () => view('auth.verify'));

        // Forgot Password
        Fortify::requestPasswordResetLinkView(fn () => view('auth.passwords.email'));

        // Reset Password
        Fortify::resetPasswordView(fn ($request) => view('auth.passwords.reset', compact('request')));

        // Confirm Password
        Fortify::confirmPasswordView(fn () => view('auth.passwords.confirm'));

        
    }
}