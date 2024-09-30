<?php

namespace Frontkom\FsInfoTransformer;

class Transformer
{
    public function transform(string $data) : string
    {
        $data = $this->processWeblinks($data);
        $data = $this->processBulletedLists($data);
        $data = $this->replaceTags($data, 'bold', 'strong');
        $data = $this->processNumberedLists($data);
        return $data;
    }

    public function processBulletedLists(string $data) : string
    {
        // The changes should be like this. An input would be
        // <list listType="bulleted"><listItem>First bullet</listItem><listItem>Second bullet</listItem></list>.
        // And then the output should become
        // <ul><li>First bullet</li><li>Second bullet</li></ul>.
        return $this->processListType($data, 'bulleted', 'ul');
    }

    public function processNumberedLists(string $data) : string
    {
        // The changes should be like this. An input would be
        // <list listType="numbered"><listItem>First bullet</listItem><listItem>Second bullet</listItem></list>.
        // And then the output should become
        // <ol><li>First bullet</li><li>Second bullet</li></ol>.
        return $this->processListType($data, 'numbered', 'ol');
    }

    protected function processListType(string $data, $list_type, $replacement_tag)
    {
        // First find the surrounding text of the list.
        $regex = '<list listType="' . $list_type . '">([\S\s]*?)<\/list>';
        $match = [];
        preg_match_all('/' . $regex . '/', $data, $match);
        if (empty($match[0])) {
            return $data;
        }
        foreach ($match[0] as $key => $value) {
            $inside = $this->replaceTags($match[1][$key], 'listItem', 'li');
            $data = str_replace($value, '<' . $replacement_tag . '>' . $inside . '</' . $replacement_tag . '>', $data);
        }
        return $data;
    }

    public function replaceTags(string $data, $tag, $replacement_tag) : string
    {
        $data = str_replace('<' . $tag . '>', '<' . $replacement_tag . '>', $data);
        $data = str_replace('</' . $tag . '>', '</' . $replacement_tag . '>', $data);
        // Also self closing tags in a couple of variations.
        $self_closing_replacement = '<' . $replacement_tag . ' />';
        $data = str_replace('<' . $tag . ' />', $self_closing_replacement, $data);
        $data = str_replace('<' . $tag . '/>', $self_closing_replacement, $data);
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
