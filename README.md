# ClassFinder
This is a class adapted from the old Illuminate\FileSystem\ClassFinder class that was in the Laravel source once upon a time. 

Call `ClassFinder::getClasses($path)` to obtain a list of fully qualified class names from the given directory. 
By default this will match any file with an extension of `.php`, but a second optional parameter can be passed in to provide a different matching pattern (ie *Foo.php)

A fully qualified class name for a single class may also be obtained through `ClassFinder::getClass($pathToClass)`
