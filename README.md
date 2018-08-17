# Xantico
Auto build Bootstrap compatible html code with PHP object oriental programming.

## Demo
Please check here: [Xantico at yhvh.tw](http://xantico.yhvh.tw/xantico-bt/)

## What is Xantico
This name is owned by a Mayan fire god. Btw it looks cool so I decide use it to name my code, a project of auto. generating bootstrap html code by PHP object oriental programming. It's very helpful if you are working a lot on building contents management system with PHP. 

## How to use Xantico
1. Put all files under model/ folder into where your models live.
2. Things under controller/ and view/ folders are not necessary.
3. Include models how you usually do.
4. Enjoy it!

## System Requirements
* I am not very sure, maybe PHP >= 5.3?
* My development environ. is under XAMPP v3.2.2. and using Boostrap 3.3.7 standards.

## Start a Bootstrap Palette
Once your can access my model, you can start your drawing! The first thing you need to do is initialize a Bootstrap Palette.

```php
$btPalette = new Xantico();
```

(you can see my sample code in view/BootstrapView.php.)

Although I wish that not too many prepare work to do, you still have to decide where you to load Bootstrap CSS/JS. I wrote down their CDN path inside Bootstrap model as const var, and you can call them by this way:

```php
$btPalette->setIsLoadBootstrapFromCDN()->setIsLoadJQueryFromCDN();
```

There are something optional to load more for my samples:

```php
$btPalette->setCustomCSSFiles("https://v3.bootcss.com/dist/css/bootstrap-theme.min.css");
$btPalette->setCustomScriptsFiles('https://v3.bootcss.com/assets/js/docs.min.js');
```

(There still one line for customizing Style Sheet contents. I am going to skip it.)

Then we can start to put some colors!

### Create a Jumbotron for instance:

```php
$jumbotron = new Jumbotron();
```

The same thing you initialize a class named Jumbotron. in below what component you want to use, there shall be a name matched class you'd like to initialize, like buttons (Button), labels (Label) or tables (Table) etc...

Give some text to the jumbotron (all setters return $this instance, you can operate in chain like this):

```php
$jumbotron->setHeader("Theme example")
    ->setText("This is a template showcasing the optional theme stylesheet included in Bootstrap. Use it as a starting point to create something more unique by building on or modifying it.");
```

That's all, Latest part you need a container to put your jumbotron in:

```php
$container = new Typography("div:container", null, array("role"=> "main"));
$container->setInnerElements(array ($jumbotron));
```

Now we finish it and render the HTML code to see your results.

```php
$btPalette->setBodyContents(array($container));
$btPalette->render(true);
```

Now switch to browser and key in the URL where you access your web page to see what does happen. There are bunch of beautiful, disciplined and well-formatted html code generated on page, and they are Bootstrap!.

My sample code mimics Bootstrap official guide webpage, built the most components what Bootstrap can do. This project would wish to keep this rhythm to create more useful Bootstrap model classes, even a full set of Bootstrap theme you can use on your works directly. 

If you like it, check more from the Docs. Have a nice day!
