<?php
/**
 * Functions related to Hungarian languages
 * 
 *
 * @theme: Manduca - focus on accessibility
 *
 * Use in child theme!
 **/

 class Hungarian_Contents {

	
   /*
	* Make hungarian definite article ('a' or 'az')
	*
	* depending on the input
	*
	* &paramter $word : word to get the article;
	*
	* */

	public static function definite_article( $word ) {
	   //only works if the language is Hungarian 
	   if ( get_locale() ==='hu_HU' ) {
		   $hungarian_regex = '/^[aáeéiíoóöőuúüű]/i';
		   if (preg_match ( $hungarian_regex, $word ) ) {
			   $article = 'az';	
		   }
		   else {
			   $article = 'a';
		   }
	   }
	   return $article;
	}
	
	/*
    * Calculate and wordsDifference of today and a given date in Hungarian. 
	 *
    *@see https://wordpress.stackexchange.com/questions/163263/relative-time-how-to-calculate-difference-beween-post-publish-date-and-current
	 *
	 *@param string $unix_timestamp : this is the reference to calculate the difference with. 
	 *@return  string HTML markup of time difference
	 * */
	public static function get_date_difference( $unix_timestamp ){
		 $date_diff =  human_time_diff( $unix_timestamp, current_time( 'timestamp' ) ) ;
		 if ( get_locale() ==='hu_HU' ) {
			$replace = array(
			 'év'  		=> 'éve',
			 'hét'		=> 'hete',
			 'hónappal'	=> 'hónapja',
			 'óra' 		=> 'órája',
			 'órával' 	=> 'órája',
			 'nappal'   => 'napja',
			 'évevel'	=> 'évvel'
			);
			$date_diff = strtr( $date_diff , $replace );
		 }
	   return $date_diff;
	}
	
	
	
 }