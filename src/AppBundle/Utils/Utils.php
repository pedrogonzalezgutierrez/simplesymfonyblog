<?php

namespace AppBundle\Utils;

class Utils {
	
    public function paginatorCheckpage($page,$maxPages) {
    	
    	if( $page<1 ) {
    		// The first page has to be always 1 
    		return 1;
    	} elseif( ($page > $maxPages) && ($maxPages != 0) ) {
    		/*
    		 * If the requested page is bigger than the last one and
    		 * there is items in the table maxPages=count()/$maxResults
    		 */
    		return $maxPages;
    	}
    	
    	return $page;
    }
    
    public function paginatorCheckmaxResults($maxResults) {
    	
    	if( $maxResults < 1 ) {
    		return 15;
    		    		
    	// Changing this allow more results per page
    	} elseif( $maxResults > 50) {    		
    		return 50;
    	}
    	return $maxResults;
    }
    
    public function paginatorGetFirstResult($page,$maxResults) {
    	
    	// Both $page and $maxResults were checked
    	return $maxResults*($page-1);
    	 
    }
    
    
    
}