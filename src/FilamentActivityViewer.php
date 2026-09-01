<?php

namespace Thettler\FilamentActivityViewer;

use BackedEnum;

class FilamentActivityViewer
{
    protected string | \BackedEnum | null $origin = null;

    protected ?string $ip = null;

    protected ?string $user_agent = null;

    public function setIp(?string $ip): FilamentActivityViewer
    {
        $this->ip = $ip;

        return $this;
    }

    public function setOrigin(BackedEnum | string | null $origin): FilamentActivityViewer
    {
        $enumClass = config('filament-activity-viewer.origin');

        if (! $enumClass) {
            $this->origin = $origin;

            return $this;
        }

        if (is_a($origin, $enumClass)) {
            $this->origin = $origin;

            return $this;
        }

        if ($origin instanceof BackedEnum) {
            throw new \InvalidArgumentException('Origin must be of type string or ' . $enumClass);
        }

        $this->origin = $enumClass::from($origin);

        return $this;
    }

    public function setUserAgent(?string $user_agent): FilamentActivityViewer
    {
        $this->user_agent = $user_agent;

        return $this;
    }

    public function getUserAgent(): ?string
    {
        return $this->user_agent;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function getOrigin(): BackedEnum | string | null
    {
        return $this->origin;
    }

    public function getMeta()
    {
        return [
            'ip' => $this->getIp(),
            'origin' => is_string($this->getOrigin()) ? $this->getOrigin() : $this->getOrigin()?->value,
            'user_agent' => $this->getUserAgent(),
        ];
    }
}
