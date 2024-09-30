# fs-info-transformer
Transform data coming from FS to regular and usable HTML

[![Test](https://github.com/frontkom/fs-info-transformer/actions/workflows/test.yml/badge.svg)](https://github.com/frontkom/fs-info-transformer/actions/workflows/test.yml)

## Installation

Install with composer.

```bash
composer require frontkom/fs-info-transformer
```

## Usage

```php
use Frontkom\FsInfoTransformer\Transformer;

$transformer = new Transformer();
$text = 'Vi viser til <webLink><href>https://www.example.com</href><linkName>gjeldende forskrift og tilhørende retningslinjer.</linkName></webLink>';
$html = $transformer->transform($text);
echo $html;
// Will output
// Vi viser til <a rel="nofollow" href="https://www.example.com">gjeldende forskrift og tilhørende retningslinjer.</a>
```

## API

### `transform(string $text): string`

Transforms the given text to HTML.

This method will run all the most common transformations on the text, including most of the ones below. For a direct link to read the implementation, [see the method in the source code directly.](https://github.com/frontkom/fs-info-transformer/blob/main/src/Transformer.php#L7)

### `replaceEmptyParagraphs(string $text): string`

### `processBulletedLists(string $text): string`

### `processNumberedLists(string $text): string`

### `replaceTags(string $data, $tag, $replacement_tag, $keep_self_closing_tags = false): string`

### `processWeblinks(string $data, bool $nofollow = true): string`

## License

GPL-2.0-or-later