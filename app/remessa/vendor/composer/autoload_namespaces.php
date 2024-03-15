{
    "autoload": {
        "psr-4": {
            "App\\": "app/"
        }
    }
}


<?php

namespace App;

class Foo
{
    public function sayHello()
    {
        echo "Hello, world!";
    }
}


composer dump-autoload


<?php

require_once __DIR__ . '/vendor/autoload.php';

$foo = new App\Foo();
$foo->sayHello(); // Output: Hello, world!


{
    "autoload": {
        "psr-4": {
            "App\\": "app/"
        }
    }
}


<?php

namespace App;

class Foo
{
    public function sayHello()
    {
        echo "Hello, world!";
    }
}
``
