<?php
/**
 * Autolad classes for Manduca
 *
 * Apply WordPress PHP standards
 *
 *
 * https://phpbits.in/autoloading-classes-php-7/
 *
 * @since : 17.12.6
 * @theme : Manduca -focus on accessibilty
  */

class Manduca_Classloader {
    const UNABLE_TO_LOAD = 'Unable to load class';
    protected static $lookup_directories = array();
    protected static $registered = 0;
 
    /**
     * Initializes directories array
     * 
     * @param array $dirs
     */
    public function __construct(array $dirs = array() )    {
        self::init($dirs);
    }
 
    /**
     * Adds directories to the existing array of directories
     * 
     * @param array | string $dirs
     */
    public static function add_dirs($dirs)
    {
        if (is_array( $dirs ) ) {
            self::$lookup_directories = array_merge(self::$lookup_directories, $dirs);
        } else {
            self::$lookup_directories[] = $dirs;
        }
    }
 
    /**
     * Adds a directory to the list of supported directories
     * Also registers "autoload" as an autoloading method
     *
     * @param array | string $dirs
     */
    public static function init( $dirs = array() )     {
        if ($dirs) {
            self::add_dirs($dirs);
        }
        if (self::$registered == 0) {
            spl_autoload_register(__CLASS__ . '::autoload');
            self::$registered++;
        }
    }
 
    /**
     * Locates a class file 
     * 
     * @param string $class
     * @return boolean
     */
    public static function autoLoad( $class ) {
        $success = FALSE;
        $filename = $class;
        // Check if it has namespace prefix
        if( false !== strpos( $class , '\\' ) ) {
            $prefixes = array( 'Web25', 'Manduca' ); // autoload only this two namespaces.
             // Does the class use the namespace prefix?
            $catched = false;
            foreach( $prefixes as $prefix ) {
                $len = strlen($prefix);
                if ( strncmp( $prefix, $class, $len) === 0) {
                    $catched = true;
                    break; 
                }
            }
            if( !$catched ) return ; // no, move to the next registered autoloader
            $namespaces = explode( '\\' , $class );
            $filename   = array_values( array_slice( $namespaces, -1 ) ) [0] ;
        }
        $filename = str_replace( '_', '-' , $filename );
        $filename   =sprintf( 'class-%s.php',
                              strtolower( $filename )
                             );
        foreach (self::$lookup_directories as $start) {
            $file = $start . $filename;
            if (self::loadFile( $file ) ) {
                $success = TRUE;
                break;
            }
        }
        
        if (!$success) {
            if (!self::loadFile(__DIR__ . DIRECTORY_SEPARATOR . $filename)) {
                //Should not do anything in case unseccessful loading
                // The plugins may use class_exist with autoload=true. 
            }
        }
        return $success;
    }
 
    /**
     * Loads a file
     * 
     * @param string $file
     * @return boolean
     */
    protected static function loadFile($file) {
                    
        if (file_exists($file)) {
                require_once $file;
                return TRUE;
        }
                    
        return FALSE;
    }
    
     public static function add_dir_and_subdirs( $directory ) {
        
        self::collect_subdirectories( $directory );
    }
}
