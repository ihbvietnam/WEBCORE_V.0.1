<?php
class Article extends CActiveRecord
{	//Config type of article
	const ARTICLE_STATICPAGE=1;
	const ARTICLE_NEWS=2;
	const ARTICLE_QA=3;
	const ARTICLE_ALBUM=4;
	const ARTICLE_VIDEO=5;
	const ARTICLE_BANNER=6;
	const ARTICLE_CONTACT=7;
}
?>