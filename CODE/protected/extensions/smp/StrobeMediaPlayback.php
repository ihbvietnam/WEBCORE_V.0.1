<?php
/**
 *  Strobe Media Playback class file.
 * 
 *  StrobeMediaPlayback  embeds Adobe's Strobe Media Playback  media player into a page.
 
 * To use StrobeMediaPlayback, set {@link src}  or  {@link srcRelative} to be the path
 * of the media source file, and set {@link width} and {@link height} for the player's
 *  dimensions.The player can be used as an mp3 player,in that case  the screen area
 *  is not needed so it can be hidden  if  appropriate dimensions are set,like width 340 and height 30.
 * You can set a playlist by including a parameter 'playlistLinks'=>array(... '{title}'=>'{media file URL}',...).
 * More advanced configuration is possible with additional parameters.
 * See StrobeMediaPlayback pdf and swfobject documentation.
 *
 *
 * @author Spiros Kabasakalis <kabasakalis@gmail.com>
 * @link http://www.myspace.com/spiroskabasakalis
 * @copyright Copyright &copy; 2010 Spiros Kabasakalis Drumaddiction Inc,
 * @license The MIT License
    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

   The above copyright notice and this permission notice shall be included in
   all copies or substantial portions of the Software.

   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
   IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
   FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
   AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
   LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
   OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
   THE SOFTWARE.
  */
 
class StrobeMediaPlayback extends CWidget
{



          /**
	 * @var string hostURL .The host part of the Yii's application URL.
	 *
	 */

         private $hostURL;

          /**
	 * @var string appBaseUrl .Relative URL of Yii's application root folder.
	 *
	 */

         private  $appBaseUrl;

         /**
	 * @var string baseUrl .The base URL of the StrobeMediaPlayback extension.
	 * This is the URL of the Yii application's assets subfolder where the
         *  contents of the smp_source folder get published in.The publishing is
         *  triggered  by publishAssets function,which is called in init function of the widget.
	 */

	private $baseUrl;


/** Listed below are the declared public variables that can be set as widget parameters.
   * To avoid confusion,It is important to realize how these variables are grouped:they are listed in the order
   * in which they  appear as arguments of the swfobject.embedSWF method.The signature is
   * embedSWF(swfUrl, id, width, height, version, expressInstallSwfurl, flashvars, params, attributes, callbackFn)
   * Ten arguments in all,first five required,the rest are optional.Notice in view file strobeMediaPlayback.php
   * that some of the public variables declared here are attributes of javascript objects that are used as arguments
   * in swfobject.embedSWF.For example variable src is an attribute of the options object,
   * which is used for  flashvars and other arguments  in swfobject.embedSWF.
   * With that said,since default values are set for the required variables,a minimal configuration of the widget
   * is required.Actually,all someone needs to display the player in a view is this code:
   * <?php  $this->widget('application.extensions.smp.StrobeMediaPlayback') ?>.The default test video file URL
   * that comes with SMP distribution will be loaded in the player.
   * Basic  configuration:
   * <?php $this->widget('application.extensions.smp.StrobeMediaPlayback',array(
                              'srcRelative'=>'/[assets subfolder]/[filename].flv',    //OR
                              'src'=>'http://[domain]/[path]/[filename].flv',
							  'src'=>'http://www.youtube.com/watch?v=yQGAedJcdlI',//Embed a video from youtube  with youtube 
							                                                                                                                               //plugin,included by default.
  *                          'src_title'=>'[Title for the media file,will show up above the player.]',
  *                          'playlistLinks'=>array(   'Title1'=>'URL1',
  *                                                                     'Title2'=>'URL2',
  *                                                                     'Title3'=>'URL3',
  *                                                                                                        ),
                              'width'=>'320',
                              'height'=>'240',
                              'allowFullScreen'=>'false'    //default is true
));?>
 * srcRelative is the path of the media file relative to the assets folder of your Yii application.
 * It is converted into an absolute URL behind the scenes.
 * src is the absolute URL path of the file to be loaded in the player,the default value is the test video
 * that comes with SMP distribution.
 * The choice between srcRelative and src is provided for convenience.If both are set,srcRelative
 * will override src,see setSourceURL method.
 * playlistLinks is an array of "title"=>'URL' pairs.It will generate a list of  media file links below the player.
 * You still need to set src or srcRelative if you use a playlist,to set the default player content.
 * You can set additional variables for more advanced configuration,check swfoject  and StrobeMediaPlayback
 *  documentation for details.If you choose to do so,you should first make sure that the variable is echoed in swfobject.embedSWF call
 *  in strobeMediaPlayback.php view file.For example to set the loop variable ,(attribute of the params object  argument,see below),
 * you should include  loop : "<?php echo $this->loop?>" in the params argument.
 */

         /**
	 * @var array playlistLinks
         *An array of playlist links ('Link description '=>'linkURL',...) to display
         * in the player's view.
	 *
	 */

         public  $playlistLinks;

          /**
	 * @var string swfUrl   .First argument of  swfobject.embedSWF
         * The path of the player: StrobeMediaPlayback.swf file.
	 * Not to be confused with the media source file path,src or srcRelative.
         *You do not need to set this variable,a default value is set in init() method.
	 */

          public $swfUrl;

        /**
	 * @var string   id .Second argument of swfobject.embedSWF
	 * The id of the div in which the player will be embedded.To embed multiple instances
         *  of the player in one page,you have to set up divs with different ids in your view,and
         *  then invoke the widget setting the id parameter accordingly.
	 */

          public $id='strobemediaplayback';

         /**
	 * @var string width .Third argument of  swfobject.embedSWF
         * Width of the player.Defaults to 640.
	 */

	public $width='640';

	/**
	 * @var string height .Fourth argument of  swfobject.embedSWF
         * Height of the player. Defaults to 480.
	 */

	public $height='480';

         /**
	 * @var string version .Fifth argument of  swfobject.embedSWF
          Minimum version of Flash Player required.Defaults to 10.0.0
	 */

        public $version='10.0.0';

          /**
	 * @var string name .Sixth argument of  swfobject.embedSWF
	 * Path of expressInstall.swf.Default value is set in init().
	 */

        public $expressInstallSwfurl ;



//  Attributes of options object,used as flashvars and other arguments  of  swfobject.embedSWF

         /**
	 * @var string srcRelative .Attribute of options object.
	 * Path of the source media file relative to the assets folder of your Yii application.
         * It is converted into an absolute URL behind the scenes.
         * If src is also set ,the latter is overriden.
	 */

          public $srcRelative;

          /**
	 * @var string src .Attribute of options object.
	 *  The absolute URL path of the media source file to be loaded in the player,
         * the default value is one of  the test videos that come with SMP distribution.
	 */

          public $src='http://mediapm.edgesuite.net/strobe/content/test/AFaerysTale_sylviaApostol_640_500_short.flv';
      // public  $src: "http://players.edgesuite.net/videos/big_buck_bunny/bbb_448x252.mp4"

         /**
	 * @var string src_title.Title of source,it is echoed above the player.Attribute of options object.
	 * See Strobe Media Playback documentation for details.
	 */

        public $src_title;

         /**
	 * @var string src_namespace_ns .Attribute of options object.
         * See Strobe Media Playback documentation for details.
	 */

        public $src_namespace_ns='http://namespace.org/mynamespace';

        /**
	* @var string src_ns_title .Attribute of options object.
	* See Strobe Media Playback documentation for details.
	*/

        public $src_ns_title='Asset Metadata with Namespace: Title';

          /**
	* @var boolean favorFlashOverHtml5Video .Attribute of options object.
	* See Strobe Media Playback documentation for details.
	*/

        public $favorFlashOverHtml5Video='true';


         /**
	* @var boolean useHTML5 .Attribute of options object.
        *There is logic in  jquery.strobemediaplayback.js  that decides whether to
        *set this property to true or false based on Flash and HTMLVideo capability
        * and the value of favorFlashOverHtml5Video property.
        *You can also set it explicitly as a widget parameter.
	* See Strobe Media Playback documentation and  jquery.strobemediaplayback.js  for details.
	*/

        public $useHTML5='false';

        /**
	 * @var string autoPlay .Attribute of options object.
	 * Whether the media starts playing as soon as it's loaded,or not.
         * See Strobe Media Playback documentation for details.
	 */

        public $autoPlay='false';

        /**
	 * @var string controlBarAutoHide .Attribute of options object.
	 * See Strobe Media Playback documentation for details.
	 */
        
        public $controlBarAutoHide='false';

          /**
	 * @var string controlBarAutoHideTimeout .Attribute of options object.
	 * See Strobe Media Playback documentation for details.
	 */
        public $controlBarAutoHideTimeout;


        /**
	 * @var string controlBarMode .Attribute of options object.
	 * See Strobe Media Playback documentation for details.
         * (docked (default), floating, none).
	 */
        public $controlBarMode='docked';



        /**
	 * @var string configuration .Attribute of options object.
	 * Path of an xml  file that configures the player.
         * The default value is a file named configuration.xml in smp_source published folder.
         * Default value is set in init() function.
         * See Strobe Media Playback documentation for details.
	 */
        
        public $configuration;

          /**
	 * @var string  poster .Attribute of options object.
	 * Path of an image that is displayed when playback begins.
         * Default value set in init() function points to  file poster.png in images subfolder of smp_source.
         * See Strobe Media Playback documentation for details.
	 */

        public $poster;

         /**
	 * @var string  endOfVideoOverlay .Attribute of options object.
	 * Path of an image that is displayed when playback completes.
         * Default value is the same as poster.
         * See Strobe Media Playback documentation for details.
	 */

        public $endOfVideoOverlay;
        
          /**
	 * @var  boolean  playButtonOverlay.Attribute of options object.
         * The default value displays a large Play button over
         *the center of the player window before playback begins.
         * See Strobe Media Playback documentation for details.
	 */

        public $playButtonOverlay='true';

          /**
	 * @var  boolean  _loop  .Attribute of options object.
         * Looping behavior,true or false.
         * See Strobe Media Playback documentation for details.
	 */

        public $_loop='false';

          /**
	 * @var  boolean  muted  .Attribute of options object.
         * Specifies whether the player initially loads content with its volume on or off.
         * See Strobe Media Playback documentation for details.
	 */

        public $muted='false';

         /**
	 * @var  number volume .Attribute of options object.
         * The initial volume of the media. Allowable values range from 0 (silent) to 1 (full volume).
         * See Strobe Media Playback documentation for details.
	 */

         public $volume='1';

          /**
	 * @var  number audioPan .Attribute of options object.
         * The left-right sound volume balance for the media.
         *  Allowable values range from -1 (full pan left) to 1 (full pan right).
         *  A value of 0 sets both sides to an equal volume.
         * See Strobe Media Playback documentation for details.
	 */

         public $audioPan='0';

       
           /**
	 * @var  string backgroundColor .Attribute of options object
         * See Strobe Media Playback documentation for details.
	 */

         public $backgroundColor='#000000';

         /**
	 * @var  string scaleMode .Attribute of options object
         *  letterbox (default), none, stretch, zoom
         * See Strobe Media Playback documentation for details.
	 */

         public $scaleMode='letterbox';

          /**
	 * @var  string plugin_YouTubePlugin .Attribute of options object
         * Location of YoutubePlugin.swf,it is set in init() function.
         * See Strobe Media Playback documentation for details.
	 */

         public $plugin_YouTubePlugin;



      //Attributes of parameters object:Eighth argument of  swfobject.embedSWF
      //Usually default values will be adequate.Most important is allowFullScreen
      //which you can set as a widget parameter.To set other attributes,echo the php variable in the
      //parameters  object of the strobemediaplayback.php view file.


          /**
	 * @var string allowFullScreen
	 * see swfobject documentation for details.
	 */

        public $allowFullScreen='true';

         /**
	 * @var string play
         * see swfobject documentation for details.
	 */

	 public $play;

         /**
	 * @var string loop
         * see swfobject documentation for details.
	 */

	 public $loop;

          /**
	  * @var string menu
          * see swfobject documentation for details.
	 */

	 public $menu;

	/**
	 * @var string quality
         * see swfobject documentation for details.
	 */

	public $quality='high';

        /**
	 * @var scale
         * see swfobject documentation for details.
	 */

	public $scale;

        /**
	 * @var string salign
         * see swfobject documentation for details.
	 */

	public $salign;

        /**
	 * @var string wmode
         * see swfobject documentation for details.
	 */

	public $wmode;

         /**
	 * @var string bgColor
         * see swfobject documentation for details.
	 */

	public $bgColor='#000000';

         /**
	 * @var string base
         * see swfobject documentation for details.
	 */

	public $base;

          /**
	 * @var swliveconnect
         * see swfobject documentation for details.
	 */

	public $swliveconnect;

          /**
	 * @var string flashvars
         * see swfobject documentation for details.
	 */

	public $flashvars;

        /**
	 * @var string devicefont
         * see swfobject documentation for details.
	 */

	public $devicefont;

        /**
	 * @var allowScriptAccess
         * see swfobject documentation for details.
	 */

	public $allowScriptAccess;

         /**
	 * @var string seamlesstabbing
         * see swfobject documentation for details.
	 */
	public $seamlesstabbing;

         /**
	 * @var string allownetworking
         * see swfobject documentation for details.
	 */
        
	public $allownetworking ;



      //Attributes of attributes object:Ninth argument of  swfobject.embedSWF
       // Only $name and $attr_id are echoed by default in  strobemediaplayback.php view file,
      //do the same for the rest,if you need to.

          /**
	 * @var name .Name of the Flash file that is embedded.
         *Not to be confused with the name of the media source file to be loaded in the player.
	 * This should be the SWF file name without the ".swf" suffix.
          *You do not need to set this variable ,a default value is provided.
         * see swfobject documentation for details.
	 */

        public $name="StrobeMediaPlayback";

          /**
	 * @var string attr_id
         * see swfobject documentation for details.
	 */

	 public $attr_id='smp';

          /**
	 * @var string align
         * Alignment  of the application region. Defaults to 'middle'.
         * see swfobject documentation for details.
	 */

	public $align='middle';




          /**
	 * @var string styleclass
         * see swfobject documentation for details.
	 */

	public $styleclass;


	/**
	 * @var string altHtmlContent
         * the HTML content to be displayed if Flash player is not installed.
	 */

	public $altHtmlContent='Either Flash Player is not installed or javascript is disabled.No HTML5 video capability.
            For best experience it is recommended that you download Flash Player from Adobe.';


        
        /**
	 * Initializes some  variables and publishes smp_source in assets folder.
	 */
	public function init()
	{
       
         $this->publishAssets();
  
        $this->hostURL=Yii::app()->getRequest()->hostInfo ;
        $this->appBaseUrl=Yii::app()->getRequest()->baseUrl ;
        $this->configuration=$this->baseUrl .'/configuration.xml';
        $this->poster=$this->baseUrl .'/images/poster.png';
        $this->expressInstallSwfurl=$this->baseUrl .'/expressInstall.swf';
        $this->plugin_YouTubePlugin=$this->baseUrl .'/YouTubePlugin.swf';
        $this->swfUrl=$this->baseUrl .'/StrobeMediaPlayback.swf';
        }

	/**
	 * Renders the widget.
	 */

	public function run()
	{
                $this->setSourceUrl();
		$this->registerClientScript();
		$this->render('strobeMediaPlayback');
	}

public function setSourceUrl() {

     if ($this->srcRelative != null  )
     $this->src=$this->hostURL.$this->appBaseUrl .'/assets'. $this->srcRelative;
}



	/**
	 * Publishes smp_source folder.
	 */

        public function publishAssets()
    {
        $dir = dirname(__FILE__).'/smp_source' ;
        $this->baseUrl = Yii::app()->getAssetManager()->publish($dir);
    }

	/**
	 * Registers the needed js files.
	 */

	public function registerClientScript()
	{


            $cs=Yii::app()->getClientScript();
			
			// You need to include jQuery only if you have not done so already  elsewhere in your page.
          	//$cs->registerScriptFile($this->baseUrl. '/lib/jquery/jquery.js',CClientScript::POS_END);

            $cs->registerScriptFile($this->baseUrl. '/lib/swfobject.js',CClientScript::POS_HEAD);

              $cs->registerScriptFile($this->baseUrl. '/jquery.strobemediaplayback.js',CClientScript::POS_HEAD);
        }


 public function playlistMarkup()
        {
             $playlistmarkup='<h1>Playlist</h1>';
            foreach ($this->playlistLinks as  $desc => $link) {

			$playlistmarkup = $playlistmarkup
				.'<a href=' . Yii::app()->getRequest()->hostinfo
                                . Yii::app()->getRequest()->baseUrl.'/'
                                . Yii::app()->getRequest()->pathinfo
                                . '?src='. CHtml::encode($link).'&title='.CHtml::encode($desc)
				. '>'
				.CHtml::encode($desc)
				. '</a><br/>';
            }

            return $playlistmarkup ;
        }

}


