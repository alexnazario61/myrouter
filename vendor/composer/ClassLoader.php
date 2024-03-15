<?php

namespace Composer\Autoload;

/**
 * ClassLoader implements a PSR-4 class loader
 *
 * See https://www.php-fig.org/psr/psr-4/
 *
 * @author Nils Adermann <naderman@naderman.de>
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
class ClassLoader
{
    /** @var array */
    private $prefixLengthsPsr4 = [];

    /** @var array */
    private $prefixDirsPsr4 = [];

    /** @var array */
    private $fallbackDirsPsr4 = [];

    /** @var array */
    private $prefixesPsr0 = [];

    /** @var array */
    private $fallbackDirsPsr0 = [];

    /** @var bool */
    private $useIncludePath = false;

    /** @var array */
    private $classMap = [];

    /** @var bool */
    private $classMapAuthoritative = false;

    /**
     * @param array $classMap Class to filename map
     */
    public function addClassMap(array $classMap): void
    {
        $this->classMap = array_merge($this->classMap, $classMap);
    }

    /**
     * Registers a set of PSR-4 directories for a given namespace, either
     * appending or prepending to the ones previously set for this namespace.
     *
     * @param string       $prefix  The prefix/namespace, with trailing '\\'
     * @param array|string $paths   The PSR-4 base directories
     * @param bool         $prepend Whether to prepend the directories
     *
     * @throws \InvalidArgumentException
     */
    public function addPsr4($prefix, $paths, $prepend = false): void
    {
        // ...
    }

    /**
     * Registers a set of PSR-0 directories for a given prefix, either
     * appending or prepending to the ones previously set for this prefix.
     *
     * @param string       $prefix  The prefix
     * @param array|string $paths   The PSR-0 root directories
     * @param bool         $prepend Whether to prepend the directories
     */
    public function add($prefix, $paths, $prepend = false): void
    {
        // ...
    }

    /**
     * Registers a set of PSR-4 directories for a given namespace,
     * replacing any others previously set for this namespace.
     *
     * @param string       $prefix The prefix/namespace, with trailing '\\'
     * @param array|string $paths  The PSR-4 base directories
     *
     * @throws \InvalidArgumentException
     */
    public function setPsr4($prefix, $paths): void
    {
        // ...
    }

    /**
     * Registers a set of PSR-0 directories for a given prefix,
     * replacing any others previously set for this prefix.
     *
     * @param string       $prefix The prefix
     * @param array|string $paths  The PSR-0 base directories
     */
    public function set($prefix, $paths): void
    {
        // ...
    }

    /**
     * Turns on searching the include path for class files.
     *
     * @param bool $useIncludePath
     */
    public function setUseIncludePath($useIncludePath): void
    {
        $this->useIncludePath = $useIncludePath;
    }

    /**
     * Can be used to check if the autoloader uses the include path to check
     * for classes.
     *
     * @return bool
     */
    public function getUseIncludePath(): bool
    {
        return $this->useIncludePath;
    }

    /**
     * Turns off searching the prefix and fallback directories for classes
     * that have not been registered with the class map.
     *
     * @param bool $classMapAuthoritative
     */
    public function setClassMapAuthoritative($classMapAuthoritative): void
    {
        $this->classMapAuthoritative = $classMapAuthoritative;
    }

    /**
     * Should class lookup fail if not found in the current class map?
     *
     * @return bool
     */
    public function isClassMapAuthoritative(): bool
    {
        return $this->classMapAuthoritative;
    }

    /**
     * Registers this instance as an autoloader.
     *
     * @param bool $prepend Whether to prepend the autoloader or not
     */
    public static function register($prepend = false): void
    {
        Autoloader::register(static::class, $prepend);
    }

    /**
     * Unregisters this instance as an autoloader.
     */
    public static function unregister(): void
    {
        Autoloader::unregister(static::class);
    }

    /**
     * Loads the given class or interface.
     *
     * @param  string    $class The name of the class
     * @return bool|null True if loaded, null otherwise
