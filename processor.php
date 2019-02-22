<?php

function parse($data, $config = []) {
    if ($data === false) {
        return false;
    }

    if (is_string($data)) {
        return $data;
    }

    if (is_callable($data)) {
        return parse($data($config), $config);
    }

    if (empty($data)) {
        return '';
    }

    $children = '';

    if (!is_string($data[0])) {
        return implode("\n", array_filter(array_map(function($item) use ($config) {
            return parse($item, $config);
        }, $data)));
    }

    $tag = null;
    $selfClosing = false;
    $attributes = [];
    foreach($data as $property => $attribute) {
        if ($property === 0) {
            $tag = $attribute;

            if ($tag[0] === '/') {
                $selfClosing = '/';
                $tag = substr($tag, 1);
            } else if ($tag[0] === '!') {
                $selfClosing = '';
            } else if ($tag[0] === '@') {
                $selfClosing = '';
                $tag = substr($tag, 1);
            }

            continue;
        } else if ($property === 1) {
            $children = parse($attribute, $config);
            continue;
        } else if ($property === 'class' && is_array($attribute)) {
            $attribute = implode(' ', array_filter($attribute));
        } else if ($property === 'style' && is_array($attribute)) {
            $results = [];
            foreach($attribute as $key => $value) {
                if ($value === false) {
                    continue;
                }
                $results[] = $key . ":" . $value;
            }

            $attribute = implode(';', $results);
        }

        if (is_array($attribute)) {
            if ($attribute[0] === 'array') {
                $attribute = implode(' ', array_filter($attribute[1]));    
            } else if ($attribute[0] === 'json') {
                $attribute = json_encode($attribute[1]);
            } else {
                $attribute = '';
            }
        }

        if ($attribute === true) {
            $attributes[] = $property;
        } else {
            $attributes[] = $property . '="' . htmlspecialchars($attribute) . '"'; 
        }
    }

    $attributeString = !empty($attributes) ? ' ' . implode(' ', $attributes) : '';

    $leftPart = '<' . $tag . $attributeString;

    if ($selfClosing !== false) {
        return $leftPart . $selfClosing .'>';
    }

    return $leftPart . '>' . $children . '</' . $tag . '>';
}

$title = false;

$html = [
    ['!doctype', 'html' => true],
    ['html', [
        ['head', [
            function($config) {
                if (empty($config['title'])) {
                    return false;
                }

                return ['title', $config['title']];
            },
            ['@link', 'rel' => 'search', 'type' => 'application/opensearchdescription+xml', 'title' => 'Test', 'href' => 'https://stackoverflow.com/opensearch.xml'],
            ['@meta', 'property' => 'og:image', 'content' => 'https://cdn.sstatic.net/Sites/stackoverflow/img/apple-touch-icon@2.png?v=73d79a89bded'],
        ]],
        ['body', [
            ['div', 'This is some text'],
            ['/br'],
            ['h1', 
                'class' => ['some class', 'class', $title ? 'conditional class' : false], 
                'style' => [
                    'background-image' => '#FFF'
                ],
                'data-json' => ['json', ['key' => 'value']], 
                'data-target' => '#test', 'data-pjax' => 0, 
                'this some text'
            ],
            'This should also work.',
            ['script', 'type' => 'text/javascript', '
                var s = "2222";
                alert(s);
            ']
        ]]
    ]],
];

echo parse($html, ['title' => 'Page title']);
