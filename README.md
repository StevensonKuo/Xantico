# Xantico
Auto build Bootstrap compatible html code with PHP object oriental programming.

## What is Xantico:
This name is owned by a Mayan fire god. Btw it looks cool. I decide use it to name my code, a project of auto. generating bootstrap html code by PHP object oriental programming. It's very helpful if you are working on building contents management system by PHP a lot. 

## How to use Xantico:
1. Put all files under model/ folder into where your models live.
2. Things under controller/ and view/ folders are not necessary.
3. Include models how you usually do.
4. Enjoy it!

## System Requirements:
* I am not very sure, maybe > PHP 5.3?
* note: My code built with Boostrap 3.3.7 standards.

## Start a Bootstrap Palette:
Once your can access my model, you can start your drawing! The first thing you need to do is initialize a Bootstrap Palette.

`$btPalette = new Bootstrap();`

(you can see my sample code in view/BootstrapView.php.)

Although I wish that not too many prepare work to do, you still have to decide where you to load Bootstrap CSS/JS. I wrote down their CDN path inside Bootstrap model as const var, and you can call them by this way:

`$btPalette->setIsLoadBootstrapFromCDN()->setIsLoadJQueryFromCDN();`

There are something optional to load more for my samples:

`        $btPalette->setCustomCSSFiles("https://v3.bootcss.com/dist/css/bootstrap-theme.min.css");
        $btPalette->setCustomScriptsFiles('https://v3.bootcss.com/assets/js/docs.min.js');
`

(There still one line for customizing Style Sheet contents. I just skip it.)

Then we can start to put your colors on!

### Create a Jumbotron for instance:

`$jumbotron = new Jumbotron();`

The same thing you initialize a class named Jumbotron. in below what component you want to use, there shall be a name matched class you'd like to initialize, like buttons (Button), labels (Label) or tables (Table) etc...

Give some text to the jumbotron:

`        $jumbotron->setHeader("Theme example")
            ->setText("This is a template showcasing the optional theme stylesheet included in Bootstrap. Use it as a starting point to create something more unique by building on or modifying it.");
`

That's all, Latest part you need a container to put your jumbotron in:

`       $container = new Typography("div:container", null, array("role"=> "main"));
        $container->setInnerElements(array ($jumbotron)); 
`

you can finish it and render the HTML code to see your results.

`       $btPalette->setBodyContents(array($container));
        $btPalette->render(true);
`

Now switch to your browser and key in the URL you can access your code. To see what does happen. There are bunch of beautiful, disciplined Bootstrap html code generated on your web page. This project would keep this rhythm to create more useful Bootstrap class, even more Bootstrap themes you can use on your work directly. 

Wish you like it!
