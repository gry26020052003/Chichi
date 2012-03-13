<?php
class Default_Model_Scrapper 
{
	private function extract_tags($html, $tag, $selfclosing = null, $return_the_entire_tag = false, $charset = 'ISO-8859-1' )
    {
		if ( is_array($tag) ){
	        $tag = implode('|', $tag);
    	}
    	$selfclosing_tags = array( 'area', 'base', 'basefont', 'br', 'hr', 'input', 'img', 'link', 'meta', 'col', 'param' );
    	if( is_null($selfclosing) ){
 	       $selfclosing = in_array( $tag, $selfclosing_tags );
    	}
    	if ( $selfclosing ){
        $tag_pattern =
            '@<(?P<tag>'.$tag.')           # <tag
            (?P<attributes>\s[^>]+)?       # attributes, if any
            \s*/?>                   # /> or just >, being lenient here
            @xsi';
	  	} else {
        $tag_pattern =
            '@<(?P<tag>'.$tag.')           # <tag
            (?P<attributes>\s[^>]+)?       # attributes, if any
            \s*>                 # >
            (?P<contents>.*?)         # tag contents
            </(?P=tag)>               # the closing </tag>
            @xsi';
     	}
    	$attribute_pattern =
        	'@
        	(?P<name>\w+)                         # attribute name
        	\s*=\s*
        	(
            	(?P<quote>[\"\'])(?P<value_quoted>.*?)(?P=quote)    # a quoted value
	
    	        |                           # or

        	    (?P<value_unquoted>[^\s"\']+?)(?:\s+|$)           # an unquoted value (terminated by whitespace or EOF)

	        )
    	    @xsi';

    //Find all tags
       		if ( !preg_match_all($tag_pattern, $html, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE ) ){
        //Return an empty array if we didn't find anything

	        return array();

    }

 

     $tags = array();
    foreach ($matches as $match){
 	   $attributes = array();
        if ( !empty($match['attributes'][0]) ){  
            if ( preg_match_all( $attribute_pattern, $match['attributes'][0], $attribute_data, PREG_SET_ORDER ) ){
                foreach($attribute_data as $attr){
                    if( !empty($attr['value_quoted']) ){
                        $value = $attr['value_quoted'];
                    } else if( !empty($attr['value_unquoted']) ){
                        $value = $attr['value_unquoted'];
                    } else {
                        $value = '';
                    }
                    $value = html_entity_decode( $value, ENT_QUOTES, $charset ); 
                    $attributes[$attr['name']] = $value;
                }
			}
        }
        $tag = array(
           'tag_name' => $match['tag'][0],
            'offset' => $match[0][1],
            'contents' => !empty($match['contents'])?$match['contents'][0]:'', //empty for self-closing tags
            'attributes' => $attributes,
        );
        if ( $return_the_entire_tag ){
            $tag['full_tag'] = $match[0][0];
        }
        $tags[] = $tag;
    }
    return $tags;
  }


  public function getall($url)
  {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	$image = $this->extract($data);
	echo $image;
	return $image;
  }

  public function extract($content)
  {

  	$data = $this->extract_tags($content, "meta");
	foreach($data as $key => $value){
		foreach($value as $key => $val){
			if($key == "attributes"){
				foreach($val as $key => $value){
					if(strstr($value, "og:image")){
					$mode = next($val);
					return $mode;
					}
				}
			}
		}
	}
	
	


	$data = $this->extract_tags($content, "link");
	foreach($data as $key => $value){
		foreach($value as $val){
			if(is_array($val)){
				if($val["rel"]== "image_src"){
				return $val["href"];
				}
			}
		}
	}

 

		 

$hidden_values = array();

$data = $this->extract_tags($content, "input");

foreach($data as $key => $value){

foreach($value as $key =>$val){

if(is_array($val)){

if($val["type"] = "hidden"){

$hidden_values[] = $val["value"];

}

}

}

}

 

 

$images = array();

$image_data = $this->extract_tags($content, "img");

foreach($image_data as $key => $value){

foreach($value as $key => $val){

if(is_array($val)){

$images[] = $val["src"];

}

}

}



$real_images = array();

foreach($hidden_values as $key => $value){

foreach($images as $image_key => $image_value){

if(strstr($image_value, $value)){

$real_images [] = $image_value;

}

}

}

if(!(empty($real_images))){

return $real_images;

}




$title = $this->extract_tags($content, "title");

foreach($title as $keuy => $value)	 {

foreach($value as $key => $val)	{

$tit = $value["contents"];

}

}



$match = array();

foreach($images as $key => $value)	{

similar_text($tit, $value, $percent);

if($percent > 30){

  $match[] = $value;

}

}


if(!(empty($match))){

return $match;

}

	

  }

 
}
