<?php

namespace App\Http\Middleware\StoreFiles;

use Log;
use Cache;
use Closure;
use Throwable;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile as IlluminateUploadedFile;
// use App\Models\Cofig;

class StoreFilesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $allowedFileExtensions = null; By default loads from env.
     * @return mixed
     */
    public function handle(Request $request, Closure $next, array $allowedFileExtensions = null, $disk = 'public')
    {
        $handledFiles = [
            'uploadErrors' => [],
            'extensionErrors' => [],
            'storageErrors' => [],
            'storedFiles' => [],
            'errors' => [],
        ];

        // the shrot way out, no files, nothing to do
        if (!$request->hasFile('files')) {
            $handledFiles['errors'][] = __('No file has been sent.');
            $request->merge(['handledFiles' => $handledFiles]);
            $response = $next($request);
            return $response;
        }

        $files = collect($request->file('files'));
        $handledFiles['uploadErrors'] = $files->map(function (IlluminateUploadedFile $file) {
            if (!$file->isValid()) {
                return __("Upload error on file ':file'.", ['file' => $file->originalName]);
            }
            return false;
        })->filter()->all();
        // filters files without upload errors
        $files = $files->filter(function (IlluminateUploadedFile $file) {
            return $file->isValid();
        });

        // map to custom wraper
        $files = $files->map(function (IlluminateUploadedFile $file) {
            return new UploadedFileWrapper($file);
        });

        // if there is an restriction in file extensions
        if (!$allowedFileExtensions) {
            $allowedFileExtensions = explode(env('ALLOWED_FILE_EXTENSIONS', ''));
            /**
             * Could be loaded from database.
             *
             * $allowedFileExtensions = Cache::store('file')->remember('allowed_file_extensions', 500, function () {
             *     return explode(
             *         ',',
             *         Cofig::where('param', 'allowed_file_extensions')->select('value')->firstOrFail()->value
             *     );
             * });
             */
        }
        if (count($allowedFileExtensions) > 0) {
            $allowedFileExtensionsStr = join(',', $allowedFileExtensions);
            $handledFiles['extensionErrors'] = $files->map(
                function (UploadedFileWrapper $file) use ($allowedFileExtensions, $allowedFileExtensionsStr) {
                    if (!$file->isExtensionValid($allowedFileExtensions)) {
                        return __(
                            "The file extension ':extension' in file ':file' is not allowed.\n".
                            "Allowed estensions are: ':allowed'.",
                            [
                                'extension' => $file->getExtension(),
                                'file' => $file->originalName,
                                'allowed' => $allowedFileExtensionsStr,
                            ]
                        );
                    }
                    return false;
                }
            )->filter()->all();
            // filtra os files sem erro de extenção
            $files = $files->filter(function (UploadedFileWrapper $file) use ($allowedFileExtensions) {
                return $file->isExtensionValid($allowedFileExtensions);
            });
        }

        // armazena files válidos
        foreach ($files as $key => $file) {
            try {
                $file->store($disk);
                $handledFiles['storedFiles'][] = $file;
            } catch (Throwable $e) {
                $handledFiles['storageErrors'][] = __(
                    "Storage error while saving file ':file'.\n:exception",
                    [
                        'file' => $file->originalName,
                        'exception' => $e->getMessage(),
                    ]
                );
            }
        }

        $handledFiles['errors'] = array_merge(
            $handledFiles['uploadErrors'],
            $handledFiles['extensionErrors'],
            $handledFiles['storageErrors']
        );
        $request->merge(['handledFiles' => $handledFiles]);

        $response = $next($request);
        if (!$response->isSuccessful()) {
            Log::critical(
                class_basename(self::class).':'.__LINE__.
                ' Deleting uploaded files. HTTP '.$response->getStatusCode()
            );
            foreach ($handledFiles['storedFiles'] as $key => $file) {
                Log::critical(
                    class_basename(self::class).':'.__LINE__.
                    " Deleting '$file->originalName'."
                );
                $file->delete();
            }
        }

        return $response;
    }
}
