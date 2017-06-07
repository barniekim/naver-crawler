# NAVER CRAWLER
A data crawler from [NAVER](https://www.naver.com) written in PHP, mainly targeted on [NAVER Blogs](https://section.blog.naver.com/), then [NAVER KIN (knowledge IN)](http://kin.naver.com), and so on.

## Usage

### Update constants in naver_blog_crawler.php as your preference, first
```php
/** constants: Line 16-21 */
$FROM_PAGE      = 1;
$TIME_FOR_NAPS  = 4;
$MAX_NUM_ERRORS = 100;
$NAVER_BLOG_ID  = "nong-up";
$DIR_DATA       = $DIR_HOME."/data/"; // change this to the right place, and make it writable
```

### Run the script on command-line shell
```
$ /usr/bin/php naver_blog_crawler.php
```

## Copyright
This project follows MIT License though, please checkout the independent license policy for [simplehtmldom](https://sourceforge.net/projects/simplehtmldom/) project which is included in this project as well.
