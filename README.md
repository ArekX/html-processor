# html-processor
PHP html processor using arrays

# Why

Combining html tags is hard. Standard string concatenation just doesn't work, it's hard to sanitize the input
and it just looks ugly. This approach uses arrays to fully create a 
structure which nicely translates to HTML.

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

# Testing

* To run tests run `composer test`.
* To generate coverage report run `composer coverage`