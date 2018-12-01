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
 }
?>