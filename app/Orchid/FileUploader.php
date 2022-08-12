<?php

namespace App\Orchid;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Orchid\Attachment\Contracts\Engine;
use Orchid\Attachment\MimeTypes;

class FileUploader implements Engine
{
    /**
     * @var UploadedFile
     */
    protected $file;

    /**
     * @var int
     */
    protected $time;

    /**
     * @var MimeTypes
     */
    protected $mimes;

    /**
     * @var string
     */
    protected $uniqueId;

    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
        $this->time = time();
        $this->mimes = new MimeTypes();
        $this->uniqueId = uniqid('', true);
    }

    public function name(): string
    {
        return sha1($this->uniqueId.$this->file->getClientOriginalName());
    }

    public function path(): string
    {
        return public_path('');
    }

    public function hash(): string
    {
        return sha1_file($this->file->path());
    }

    public function time(): int
    {
        return $this->time;
    }

    public function extension(): string
    {
        $extension = $this->file->getClientOriginalExtension();

        return empty($extension)
            ? $this->mimes->getExtension($this->file->getClientMimeType(), 'unknown')
            : $extension;
    }

    public function mime(): string
    {
        return $this->mimes->getMimeType($this->extension())
            ?? $this->mimes->getMimeType($this->file->getClientMimeType())
            ?? 'unknown';
    }

    public function fullName(): string
    {
        return Str::finish($this->name(), '.').$this->extension();
    }
}
