<?php

declare(strict_types=1);

namespace Thettler\FilamentActivityViewer\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Thettler\FilamentActivityViewer\Facades\FilamentActivityViewer;

final class FilamentActivityViewerOriginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string|\BackedEnum $origin): Response
    {
        FilamentActivityViewer::setOrigin($origin);
        FilamentActivityViewer::setIp($request->ip());
        FilamentActivityViewer::setUserAgent($request->userAgent());

        return $next($request);
    }
}
