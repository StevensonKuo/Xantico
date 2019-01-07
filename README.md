# Xantico
A PHP helper to build Bootstrap compatible html code automatically using OOP syntax.

## Demo
Please check demo pages here:

[Basic CSS](http://xantico.yhvh.tw/). 

[Components](http://xantico.yhvh.tw/index.php?page=components). 

[Bootstrap theme](http://xantico.yhvh.tw/index.php?page=theme). 

[Tutorial Video](https://www.youtube.com/watch?v=6psvQBJ8EZg&feature=youtu.be)

This page is all the same with a demo page on Bootstrap official website. I write my php code below to show you how to achieve it. Also the worth part is to have a chance looking at html source code.

## What is Xantico
This name is owned by a Mayan fire god. Btw it looks cool so I decide use it to name my code, a project of auto. generating bootstrap html code by PHP object oriental programming. It's very helpful if you are working a lot on building contents management system with PHP. 

## How to use Xantico (Installation)
1. Put all files under model/ folder into where your models live.
2. Things under controller/ and view/ folders are not necessary. 
3. Include models how you usually do.
4. Enjoy it!

A trendy way to install, by composer:
```
composer require xantico/xantico
```

## System requirements
* I am not very sure, maybe PHP >= 5.3?
* My development environ. is under XAMPP v3.2.2. Using Boostrap 3.3.7 standards.

## Start a Bootstrap palette
Once your can access my model, you can start your painting! The first thing you need to do is initialize a palette.

```php
$btPalette = new Xantico();
```

(you can see my sample code in view/BootstrapView.php.)

Although I wish that there ain't too many prepare works to do, you still have to decide where you to load Bootstrap CSS/JS. I wrote down their CDN path inside Bootstrap model as const. var, and you can call them by this way:

```php
$btPalette->setIsLoadBootstrapFromCDN()->setIsLoadJQueryFromCDN();
```

There are something optional to load more for my samples:

```php
$btPalette->setCustomCSSFiles("https://v3.bootcss.com/dist/css/bootstrap-theme.min.css");
// Bootstrap theme CSS.
$btPalette->setCustomScriptsFiles('https://v3.bootcss.com/assets/js/docs.min.js');
// Bootstrap tutorial page CSS.
```

(There still one line for customizing Style Sheet contents. I am going to skip it.)

Then you can start to put some color!

### Create a Jumbotron for instance

```php
$jumbotron = new Jumbotron();
```

The same thing you initialize a class named Jumbotron. in below what component you want to use, there shall be a name matched class you'd like to initialize, like buttons (Button), labels (Label) or tables (Table) etc...

Give some text to the jumbotron (all setters return $this instance, you can operate in chain like Javascript):

```php
$jumbotron->setHeader("Theme example")
    ->setText("This is a template showcasing the optional theme stylesheets included in Bootstrap. Use it as a starting point to create something more unique by building on or modifying it.");
```

Almost done. Then you need a container to put your jumbotron in:

```php
$container = new Container();
$container->setInnerElements($jumbotron);
```

Now we finish it and render the HTML for your results.

```php
$btPalette->setBodyContents($container);
$btPalette->render(true); // the argument is for printing out result directly.
```

To switch to browser and key in the URL where you access your web page to see what does happen. There are bunch of beautiful, disciplined and well-formatted html code generated, and they are Bootstrap!.

My sample code mimics almost all of Bootstrap official guide web-page. This project would wish to keep this rhythm to create more useful Bootstrap model classes, even a full set of Bootstrap theme. You can use them on works directly. 

If you like it, check more from the docs. Have a nice day!
