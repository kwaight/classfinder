# ClassFinder
This is a class adapted from the old Illuminate\FileSystem\ClassFinder class that was in the Laravel source once upon a time. 

Call `ClassFinder::findClasses($path)` to obtain a list of fully qualified class names from the given directory. 
By default this will match any file with an extension of `.php`, but a second optional parameter can be passed in to provide a different matching pattern (eg *Service.php)

If the directory is potentially non-existent, `ClassFinder::findClassesSafely($path)` can be called, which will return an empty array if the directory does not exist.

A fully qualified class name for a single class may also be obtained through `ClassFinder::findClass($pathToClass)`
