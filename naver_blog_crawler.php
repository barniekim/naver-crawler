<?php
/**
 * NAVER DATA CRAWLER
 *
 * Barnabas Kim <his.barnabas@gmail.com>
 */

/** maximize memory allocation */
ini_set("memory_limit" , -1);

/** include extensions */
$DIR_HOME = dirname(__FILE__);
@require_once($DIR_HOME."/lib/simple_html_dom.php");
@require_once($DIR_HOME."/lib/function.common.php");

/** constants */
$FROM_PAGE      = 1;
$TIME_FOR_NAPS  = 4;
$MAX_NUM_ERRORS = 100;
$NAVER_BLOG_ID  = "nong-up";
$DIR_DATA       = $DIR_HOME."/data/"; // change this to the right place, and make it writable

/** variables */
$num_errors = 0;
$page_start = $FROM_PAGE;
$base_url   = "http://blog.naver.com/PostList.nhn".
                  "?blogId=".$NAVER_BLOG_ID.
                  "&categoryNo=0".
                  "&from=postList".
                  "&currentPage=";

echo "check start/end page...\n";

/** get the first & last pages from of the blog */
do{

    if($num_errors>$MAX_NUM_ERRORS){ return; }
    if($num_errors>0){ echo "trials: $num_errors\n";}

    $requestURL = $base_url.$page_start;

    $html = (file_get_contents($requestURL, 0, get_rand_context()));
    if(!$html){ $num_errors++; $page_start++; continue; }

    $html = str_get_html(iconv("EUC-KR", "UTF-8", $html));
    if(!$html){ $num_errors++; $page_start++; continue; }

    $obj = $html->find(
        "div[id=wrapper] > ".
        "div[id=content-area] > ".
        "div[id=post-area] > ".
        "div[id=category-name] > ".
        "table[class=post-body] > ".
        "strong[class=itemSubjectBoldfont]", 0); 
    if(!$obj){ $num_errors++; $page_start++; continue; }

    $page_end = $obj->plaintext;

    /** release memory */
    unset($obj);
    unset($html);

}while(!$page_end);

echo "page_start: ".$page_start.", ".
     "page_end: ".$page_end."\n\n";

/** download the whole page as a single html document to the disk */
for($page=$page_start; $page<=$page_end; $page++){

    /** crawl politely, taking a nap at least N sec, at each time */
    sleep($TIME_FOR_NAPS);

    $requestURL = $base_url.$page;
    $html = (file_get_contents($requestURL, 0, get_rand_context()));
    $html = str_get_html(iconv("EUC-KR", "UTF-8", $html));
    if(!$html){ unset($html); continue; }

    /** save it to the file */
    $fp = fopen($DIR_DATA."/".$NAVER_BLOG_ID."_".$page, "w");
    if(!$fp){ 
        echo "can't save the data to the file."; 
        unset($html); 
        continue;
    } 
    fwrite($fp, $html);
    fclose($fp);
    unset($html);

    echo "blogId: {$NAVER_BLOG_ID}, page: {$page} saved.\n";
}
?>
