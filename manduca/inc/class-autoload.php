<?php
/*
 * This autoload the files and subdirectories of the given path
 *
 *
 * @ Theme: Manduca - focus on accessibility
 * @ since 17.12.5
 **/

class Autoload {
	
	protected $basepath;
	protected $dir_content = array();
	
	/*
	 * Megnyitja a köynvtár minden fájlját 
	 *
	 * @parameter $subdir boolean : true = az alkönyvtárakat is.
	 * 								false= csak az aktuális könyvtárat
	 **/
	protected function load_files_from_current_dir( $basepath, $subdir=false  ){
		echo '<br>hívás: '. $basepath;
		
		$basepath = trailingslashit( $basepath );
		$cdir = scandir( $basepath );
					
		foreach ($cdir as $key => $filename) {
		   if ( !in_array( $filename, array( "." , ".." ) ) ) {
							
			  if ( is_dir( $basepath . DIRECTORY_SEPARATOR . $filename ) && $subdir ) {
				 $this->dir_content[ $filename ] = $this->load_files_from_current_dir( $basepath . $filename, $subdir );
			  }
			  
			  else {
				if( strpos( $filename , '.php' ) !== false ) {
									echo '<br> Open: '.$basepath .$filename;
					require_once( $basepath .$filename );
				}
				 
			  }
		   }
		}
	}
	
	/*
	 * Load all php files from the directory and subdirectories
	 *
	 * @param $basepath string : directory to load
	 **/
	public function load_files_from_all_dir( $basepath ){
		$this->load_files_from_current_dir( $basepath, true );
	}
	
	/*
	 * Load all php files from only the given directory 
	 *
	 * @param $basepath string : directory to load
	 **/
	public function load_files_from_one_dir( $basepath ) {
				$this->load_files_from_current_dir( $basepath );
		
	}	
}