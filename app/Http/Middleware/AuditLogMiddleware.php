<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AuditLogMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $start = microtime(true);

        // If you want to reuse an incoming request id header, you can:
        // $requestId = $request->header('X-Request-Id') ?: (string) Str::uuid();
        $requestId = (string) Str::uuid();

        try {
            $response = $next($request);

            $this->writeAudit($request, $response, $requestId, $start);

            return $response;
        } catch (Throwable $e) {
            // Log exception as a 500 (or you can map known HTTP exceptions)
            $this->writeAudit($request, null, $requestId, $start, $e);

            throw $e;
        }
    }

    protected function writeAudit(
        Request $request,
        ?Response $response,
        string $requestId,
        float $start,
        ?Throwable $e = null
    ): void {
        // audit logging must never break the API
        try {
            $route = $request->route();

            $user = Auth::guard('api')->user();

            AuditLog::create([
                'request_id' => $requestId,
                'user_id' => $user?->id,
                'guard' => 'api',

                'method' => $request->getMethod(),
                'path' => '/' . ltrim($request->path(), '/'),
                'route_name' => $route?->getName(),
                'action' => $route?->getActionName(),

                'status_code' => $response?->getStatusCode() ?? 500,

                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),

                'duration_ms' => (int) round((microtime(true) - $start) * 1000),

                'error_class' => $e ? get_class($e) : null,
                'error_message' => $e ? $e->getMessage() : null,
            ]);
        } catch (Throwable $ignored) {
            // swallow
        }
    }
}
