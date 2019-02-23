# html-processor
PHP html processor using arrays

# Why

Combining html tags is hard. Standard string concatenation just doesn't work, it's hard to sanitize the input
and it just looks ugly. This approach uses arrays to fully create a 
structure which nicely translates to HTML. But what about template engines like Blade, Mustache, etc?

This was not supposed to replace them, even though it fully could. This was intended so that it can be used in programmatic places where
you need to create tags dynamically like recursive menu generators, but do not want to use template engines. Examples for these are 
widgets which output html or in other places of the code where you would need to output programmatically.

So this:
```php
[
    ['@!DOCTYPE', 'html' => true],
    ['html', 'lang' => 'en-US', [
        ['head', [
            ['title', 'This is some title']
        ]],
        ['body', [
            ['h1', 'This is some page title'],
            ['button', 'This is a button'],
            ['a', 'href' => '#link', 'this is a link']
        ]]
    ]]
]
```

Translates nicely into:

```html
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>This is some title</title>
    </head>
    <body>
        <h1>This is some page title</h1>
        <button>This is a button</button>
        <a href="#link">this is a link</a>
    </body>
</html>
```


# Usage


```php
$renderer = new ArekX\HtmlProcessor\Html();

echo $renderer->render(['div']); // Renders: <div></div>
echo $renderer->render(['div', 'class' => 'class']); // Renders: <div class="class"></div>
echo $renderer->render(['div', 'class' => 'class', 'Inner content']); // Renders: <div class="class">Inner content</div>
echo $renderer->render(['div', ['text', 'value']]); // <div>textvalue</div>
echo $renderer->render(['div', ['text', 'value', ['another-element']]]); // <div>textvalue<another-element></another-element></div> 
```

## Self closing tags

```php
echo $renderer->render(['@input', 'type' => 'text']); // Renders: <input type="text">
echo $renderer->render(['/br']); // Renders: <br/>
```

## Conditional rendering

You can conditionally render elements or text in arrays. If something is not to be rendered you can pass `false`
and that part of the rendering will be skipped.

```php
$condition = false;
echo $renderer->render([['p', [
    $condition ? ['strong', 'Item wrapped in strong'] : false,
    'test'
]]]); // Renders: <p>test</p>
```

### Using callbacks

You can also use callbacks in elements to handle conditional rendering. `render($template, $config = [])` function accepts
additional optional parameter for configuration which will be passed to all callbacks used in the template array.

```php
echo $renderer->render([['p', [
    function ($config) {
        return $config['wrapped'] ? ['strong', 'Item wrapped in strong'] : false;
    },
    'test'
]]], ['wrapped' => true]); // Renders: <p><strong>Item wrapped in strong</strong>test</p> 
``` 

## Attributes conditional rendering

If you pass `true` to an attribute you will just render that attribute without a value:

**NOTE:** All attribute values rendered are encoded using `htmlspecialchars`.

```php
echo $renderer->render(['div', 'attribute' => true]); // Renders: <div attribute></div> 
```

If you pass `false` as a value to any attribute that attribute wont be rendered:

```php
echo $renderer->render(['div', 'class' => false, 'data-test' => 'test']); // Renders: <div data-test="test"></div> 
```

Value for attribute can also be a callback:

```php
echo $renderer->render(['div', 'class' => function($config) {
    return $config['class'];
}, 'data-test' => 'test'], ['class' => ['class1', 'class2']]); // Renders: <div class="class1 class2" data-test="test"></div> 
```

## Special attributes

If you look closely `class="class1 class2"` in above example, it is rendered using `'class' => ['class1', 'class2']`. There are special
renderers for few fields like `class` and `style` which allows non-string values which can be parsed.

`class` attribute allows an array which will be joined with all `false` values removed. It also allows for a class value to be a callable.

`style` attribute allows for `['property' => 'value']` which will render to `property: value`. Value can also be a callable which will get
executed to return property value. If a property value is `false` it will be skipped.


### Json attributes

You can encode arrays as json in attributes:

```php
$array = [
    'key1' => 'value1',
    'key2' => 'value2'
];
echo $renderer->render(['div', 'data-prop' => ['json' => $array]]);
// Renders: <div data-prop="{&quot;key1&quot;:&quot;value1&quot;,&quot;key2&quot;:&quot;value2&quot;}"></div>
```

# Testing

* To run tests run `composer test`.
* To generate coverage report run `composer coverage`