<?php

declare(strict_types=1);

namespace CrazyGenius\Libs\Io;

final class AsyncReader
{
    /**
     * AsyncReader constructor.
     *
     * @param resource $resource
     */
    private function __construct(private $resource)
    {
    }

    /**
     * @param resource $resource
     *
     * @return static
     */
    public static function create($resource): self
    {
        if (!is_resource($resource)) {
            throw new \InvalidArgumentException('Resource expected');
        }

        return new self($resource);
    }

    public function lines(): \iterable
    {
        while (!feof($this->resource)) {
            $line = fgets($this->resource);
            if (!$line) {
                break;
            }

            yield $line;
        }
    }

    public function chunks(int $size): \iterable
    {
        while (!feof($this->resource)) {
            $line = fread($this->resource, $size);
            if (!$line) {
                break;
            }

            yield $line;
        }
    }
}

