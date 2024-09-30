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
        // <webLink><href>https://www.example.com</href><linkName>gjeldende forskrift og tilhørende retningslinjer.
        // </linkName></webLink>.
        // And then the output should become
        // <a rel="nofollow" href="https://www.example.com">gjeldende forskrift og tilhørende retningslinjer.</a>
        $regex = '<webLink><href>(.*?)<\/href>(<linkName>([\S\s]*?)<\/linkName>)?<\/webLink>';
        $replace = $nofollow ? '<a rel="nofollow" href="$1">$3</a>' : '<a href="$1">$3</a>';
        return preg_replace('/' . $regex . '/', $replace, $data);
    }
}
