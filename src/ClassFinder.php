<?php

namespace WSNYC\ClassFinder;

use Symfony\Component\Finder\Finder;

class ClassFinder
{
    /**
     * Find all the class and interface names in a given directory.
     *
     * @param  string  $directory
     * @param  string  $pattern  An optional string pattern, eg '*Service.php'
     * @return array
     */
    public static function findClasses($directory, $pattern = '*.php')
    {
        $classes = [];
        if(file_exists($directory)) {
            $finder = Finder::create()->in($directory)->name($pattern);
            foreach ($finder as $file) {
                $classes[] = self::findClass($file->getRealPath());
            }
        }
        return array_filter($classes);
    }

    /**
     * Extract the class name from the file at the given path.
     *
     * @param  string  $path
     * @return string|null
     */
    public static function findClass($path)
    {
        $namespace = null;
        $tokens = token_get_all(file_get_contents($path));
        foreach ($tokens as $key => $token) {
            if (self::tokenIsNamespace($token)) {
                $namespace = self::getNamespace($key + 2, $tokens);
            } elseif (self::tokenIsClassOrInterface($token)) {
                return ltrim($namespace.'\\'.self::getClass($key + 2, $tokens), '\\');
            }
        }
        return null;
    }

    /**
     * Find the namespace in the tokens starting at a given key.
     *
     * @param  int  $key
     * @param  array  $tokens
     * @return string|null
     */
    protected static function getNamespace($key, array $tokens)
    {
        $namespace = null;
        $tokenCount = count($tokens);
        for ($i = $key; $i < $tokenCount; $i++) {
            if (self::isPartOfNamespace($tokens[$i])) {
                $namespace .= $tokens[$i][1];
            } elseif ($tokens[$i] == ';') {
                return $namespace;
            }
        }
        return null;
    }

    /**
     * Find the class in the tokens starting at a given key.
     *
     * @param  int  $key
     * @param  array  $tokens
     * @return string|null
     */
    protected static function getClass($key, array $tokens)
    {
        $class = null;
        $tokenCount = count($tokens);
        for ($i = $key; $i < $tokenCount; $i++) {
            if (self::isPartOfClass($tokens[$i])) {
                $class .= $tokens[$i][1];
            } elseif (self::isWhitespace($tokens[$i])) {
                return $class;
            }
        }
        return null;
    }

    /**
     * Determine if the given token is a namespace keyword.
     *
     * @param  array|string  $token
     * @return bool
     */
    protected static function tokenIsNamespace($token)
    {
        return is_array($token) && $token[0] == T_NAMESPACE;
    }

    /**
     * Determine if the given token is a class or interface keyword.
     *
     * @param  array|string  $token
     * @return bool
     */
    protected static function tokenIsClassOrInterface($token)
    {
        return is_array($token) && ($token[0] == T_CLASS || $token[0] == T_INTERFACE);
    }

    /**
     * Determine if the given token is part of the namespace.
     *
     * @param  array|string  $token
     * @return bool
     */
    protected static function isPartOfNamespace($token)
    {
        return is_array($token) && ($token[0] == T_STRING || $token[0] == T_NS_SEPARATOR);
    }

    /**
     * Determine if the given token is part of the class.
     *
     * @param  array|string  $token
     * @return bool
     */
    protected static function isPartOfClass($token)
    {
        return is_array($token) && $token[0] == T_STRING;
    }

    /**
     * Determine if the given token is whitespace.
     *
     * @param  array|string  $token
     * @return bool
     */
    protected static function isWhitespace($token)
    {
        return is_array($token) && $token[0] == T_WHITESPACE;
    }
}
