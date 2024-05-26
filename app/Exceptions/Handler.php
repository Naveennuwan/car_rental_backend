<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function report(Throwable $exception)
    {
        $host = request()->getHost(); // Gets the host of the current request
        $isNotLocalhost = !in_array($host, ['localhost', '127.0.0.1', '::1']); // True if host is not localhost or loopback

        // Define the exceptions you want to potentially ignore
        $ignoredExceptions = [
            "Illuminate\Auth\AuthenticationException",
            "Illuminate\Session\TokenMismatchException",
            "Illuminate\Validation\ValidationException"
        ];

        // Only run your custom logic if the request is not from localhost and the exception is not one of the ignored types
        if ($isNotLocalhost && !in_array(get_class($exception), $ignoredExceptions)) {

            // Specific handling for validation exceptions
            if ($exception instanceof ValidationException) {
                $data = json_encode(collect(request()->all())->map(function ($value, $key) {
                    return (in_array($key, $this->dontFlash)) ? '(redacted)' : $value;
                })->toArray());

                Log::info('[VALIDATION ERROR][' . request()->ip() . '][DATA] ' . $data . '[ERRORS] ' . json_encode($exception->errors()));
            } else {
                // General handling for all other exceptions
                // Customize this part as needed
                $context = [
                    'URL' => request()->fullUrl(),
                    'IP' => request()->ip(),
                    'User ID' => auth()->check() ? auth()->user()->id : null, // Capture user ID if authenticated
                    'Input' => json_encode(collect(request()->all())->map(function ($value, $key) {
                        return (in_array($key, $this->dontFlash)) ? '(redacted)' : $value;
                    })->toArray()),
                ];

                // Example of logging error details - customize the message and data as needed
                Log::error('[ERROR][' . get_class($exception) . ']', ['context' => $context, 'exception' => $exception->getMessage()]);
            }

            $rootPath = base_path() . DIRECTORY_SEPARATOR; // Get the root path of the Laravel application
            // Get the full URL of the current request
            $fullUrl = request()->fullUrl();
            // Construct the Markdown link with the dynamic URL
            $linkText = "Check out [$fullUrl]($fullUrl)";

            $trace = $exception->getTrace();
            $filteredTrace = array_filter($trace, function ($traceEntry) {
                // Check if the file exists in the trace and if it contains the vendor path we want to exclude
                return isset($traceEntry['file']) && !str_contains($traceEntry['file'], 'vendor');
            });

            // Convert the filtered trace array back to a string format for readability
            $traceString = '';
            foreach ($filteredTrace as $index => $entry) {
                $file = isset($entry['file']) ? str_replace($rootPath, '', $entry['file']) : 'N/A'; // Remove the root path
                $line = $entry['line'] ?? 'N/A';
                $function = $entry['function'] ?? 'N/A';
                $class = $entry['class'] ?? 'N/A';
                $type = $entry['type'] ?? 'N/A';

                // Format each trace entry
                $traceString .= ($index) . ". `{$file}({$line}): {$class}{$type}{$function}`\n"; // Markdown numbered list
            }


            $teamsPayload = [
                "type"        => "message",
                "attachments" => [
                    [
                        "contentType" => "application/vnd.microsoft.card.adaptive",
                        "content"     => [
                            "type"    => "AdaptiveCard",
                            "body"    => [
                                [
                                    "type"   => "TextBlock",
                                    "size"   => "Large",
                                    "weight" => "Bolder",
                                    "text"   => "Exception : " . now()->toDateTimeString()
                                ],
                                [
                                    "type" => "TextBlock",
                                    "text" => $linkText,
                                    "wrap" => true
                                ],
                                [
                                    "type" => "TextBlock",
                                    "text" => get_class($exception),
                                    "wrap" => true
                                ],
                                [
                                    "type" => "TextBlock",
                                    "text" => "Message : " . $exception->getMessage(),
                                    "wrap" => true
                                ],
                                [
                                    "type" => "TextBlock",
                                    "text" => "File : " . str_replace($rootPath, '', $exception->getFile()),
                                    "wrap" => true
                                ],
                                [
                                    "type" => "TextBlock",
                                    "text" => "Line : " . $exception->getLine(),
                                    "wrap" => true
                                ],
                                [
                                    "type" => "TextBlock",
                                    "text" => "User : " . (auth()->check() ? auth()->user()->id : null),
                                    "wrap" => true
                                ],
                                [
                                    "type" => "TextBlock",
                                    "text" => "Ip : " . request()->ip(),
                                    "wrap" => true
                                ],
                                [
                                    "type"     => "TextBlock",
                                    "text"     => collect(request()->all())->map(function ($value, $key) {
                                        if (in_array($key, $this->dontFlash)) {
                                            return "{$key}: (redacted)";
                                        } else {
                                            return "{$key}: {$value}";
                                        }
                                    })->implode("\n"),
                                    "wrap"     => true,
                                    "markdown" => false
                                ],
                                [
                                    "type"     => "TextBlock",
                                    "text"     => $traceString,
                                    "wrap"     => true,
                                    "size"     => "Small",
                                    "markdown" => true
                                ],
                                [
                                    "type" => "TextBlock",
                                    "text" => "<at>dimuth</at>, <at>harshana</at>, <at>naveen</at>, <at>pasan</at>, <at>yogakrishanthi</at>",
                                    "size" => "Small"
                                ]
                            ],
                            "schema"  => "http://adaptivecards.io/schemas/adaptive-card.json",
                            "version" => "1.2",
                            "msteams" => [
                                "width"    => "Full",
                                "entities" => [
                                    [
                                        "type"      => "mention",
                                        "text"      => "<at>dimuth</at>",
                                        "mentioned" => [
                                            "id"   => "dimuth@konnect.team",
                                            "name" => "dimuth"
                                        ]
                                    ],
                                    [
                                        "type"      => "mention",
                                        "text"      => "<at>harshana</at>",
                                        "mentioned" => [
                                            "id"   => "harshana@konnect.team",
                                            "name" => "harshana"
                                        ]
                                    ],
                                    [
                                        "type"      => "mention",
                                        "text"      => "<at>naveen</at>",
                                        "mentioned" => [
                                            "id"   => "naveen@konnect.team",
                                            "name" => "naveen"
                                        ]
                                    ],
                                    [
                                        "type"      => "mention",
                                        "text"      => "<at>pasan</at>",
                                        "mentioned" => [
                                            "id"   => "pasan@konnect.team",
                                            "name" => "pasan"
                                        ]
                                    ],
                                    [
                                        "type"      => "mention",
                                        "text"      => "<at>yogakrishanthi</at>",
                                        "mentioned" => [
                                            "id"   => "yogakrishanthi@konnect.team",
                                            "name" => "yogakrishanthi"
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ];

            // Send the notification to Microsoft Teams
            $webhookUrl = 'https://sonasu.webhook.office.com/webhookb2/14489207-1343-47c5-82ae-3bc6f89fcca5@9de96f7f-bb2c-4950-b193-74037f8b3e99/IncomingWebhook/01e83ffe9db7426eb361ae5eb0bf2294/06c25797-148e-4117-9034-707d000c4642'; // Replace with your actual webhook URL

            try {
                Http::post($webhookUrl, $teamsPayload);
            } catch (\Exception $e) {
                Log::error('Failed to send exception notification to Teams', ['exception' => $e->getMessage()]);
            }
        }
        // Continue with the default exception reporting...
        parent::report($exception);
    }
}
