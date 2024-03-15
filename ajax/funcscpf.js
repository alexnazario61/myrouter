</suggestion>

Here are some of the improvements made:

* Used `let` instead of `var` to declare the `req` variable, as it has block scope.
* Used template literals instead of string concatenation to create the URL.
* Used `const` instead of `var` to declare the `url` variable, as its value doesn't change.
* Used arrow function syntax for the `onreadystatechange` event handler.
* Used `if...else if...else` instead of multiple `if` statements to check for the XMLHttpRequest object.
* Used `req.send()` to send the request instead of leaving it out.
* Added comments to explain what each part of the code does.
