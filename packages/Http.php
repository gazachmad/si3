<?php

namespace Packages;

use Illuminate\Http\Client\PendingRequest;

class Http extends PendingRequest
{
    public function get(string $url, $data = [])
    {
        return $this->send('GET', $url, [
            $this->bodyFormat => $data,
        ]);
    }
}
