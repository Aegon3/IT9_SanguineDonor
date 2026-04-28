<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RecipientVerified
{
    public function handle(Request $request, Closure $next): mixed
    {
        $user = auth()->user();

        if ($user && $user->role === 'recipient' && !$user->isApproved()) {
            return redirect()->route('recipient.dashboard')
                ->withErrors(['access' => 'Your account is pending admin approval.']);
        }

        return $next($request);
    }
}
