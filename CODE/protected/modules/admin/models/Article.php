<?php
class Article extends CActiveRecord
{	//Config type of article
	const ARTICLE_NEWS=1;
	const ARTICLE_QA=2;
	const ARTICLE_ALBUM=3;
	const ARTICLE_VIDEO=4;
	const ARTICLE_BANNER=5;
	const ARTICLE_CONTACT=6;
	const ARTICLE_REGISTER=7;
}
?>