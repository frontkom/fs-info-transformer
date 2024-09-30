<?php

namespace Frontkom\FsInfoTransformer;

class Transformer
{
    public function transform(string $data) : string
    {
        $data = $this->processWeblinks($data);
        return $data;
    }

    public function processWeblinks(string $data, bool $nofollow = true) : string
    {
        // The changes should be like this. An input would be
        // <webLink><href>https://www.example.com</href><linkName>gjeldende forskrift og tilhørende retningslinjer.</linkName></webLink>
        // And then the output should become
        // <a rel="nofollow" href="https://www.example.com">gjeldende forskrift og tilhørende retningslinjer.</a>
        if ($nofollow) {
            return preg_replace('/<webLink><href>(.*?)<\/href>(<linkName>(.*?)<\/linkName>)?<\/webLink>/', '<a rel="nofollow" href="$1">$3</a>', $data);
        }
        return preg_replace('/<webLink><href>(.*?)<\/href>(<linkName>(.*?)<\/linkName>)?<\/webLink>/', '<a href="$1">$3</a>', $data);
    }
}
