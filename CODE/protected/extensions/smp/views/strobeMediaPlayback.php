<?php
/**
 * The view file for StrobeMediaPlayback.
 *
 * @author Spiros Kabasakalis <kabasakalis@gmail.com>
 * @link http://www.myspace.com/spiroskabasakalis.
 * @copyright Copyright &copy; 2010 Drumaddiction Inc.
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
?>
 <script type="text/javascript">
            $(function(){
        //
        //options populates the flashvars and other arguments  of swfobject.embedSWF
        // in jquery.strobemediaplayback.js

           var options = {

           //BASIC CONFIGURATION OPTIONS
            id:"<?php echo $this->attr_id ?>" ,  //not to be confused with the id of the div in which the player replaces,
                                                                              //the second swfobject.embedSWF argument.This one  is used in attributes argument,defaults to 'smp'.
            swf: "<?php echo $this->swfUrl ?>",
            width:"<?php echo $this->width ?>",
            height:"<?php echo $this->height ?>",
            src:"<?php echo $this->src ?>",
            src_title:"<?php echo $this->src_title ?>",
            src_namespace_ns:"<?php echo $this->src_namespace_ns ?>",
            src_ns_title:"<?php echo $this->src_ns_title ?>",          
            minimumFlashPlayerVersion:"<?php echo $this->version ?>",
            expressInstallSwfUrl:"<?php echo $this->expressInstallSwfurl ?>",
            useHTML5:<?php echo $this->useHTML5 ?>,
            favorFlashOverHtml5Video:<?php echo $this->favorFlashOverHtml5Video?>,
            controlBarAutoHide:"<?php echo $this->controlBarAutoHide ?>",
            controlBarAutoHideTimeout:"<?php echo $this->controlBarAutoHideTimeout ?>",
            controlBarMode:"<?php echo $this->controlBarMode ?>",
            configuration:"<?php echo $this->configuration ?>",
            poster:"<?php echo $this->poster ?>",
            endOfVideoOverlay:"<?php echo $this->endOfVideoOverlay ?>",
            playButtonOverlay:<?php echo $this->playButtonOverlay ?>,
            loop:<?php echo $this->_loop ?>,
            muted:<?php echo $this->muted?>,
            volume:<?php echo $this->volume?>,
            audioPan:<?php echo $this->audioPan?>,
            autoPlay:"<?php echo $this->autoPlay ?>",
            plugin_YouTubePlugin:"<?php echo $this->plugin_YouTubePlugin ?>",
           

             //ADVANCED CONFIGURATION OPTIONS
             //More advanced attributes than those listed below are available,
             //see Using Strobe Media Playback PDF for details.To make them available  as widget
             //parameters,define public php variables in class file  and echo them here.

            backgroundColor:'<?php echo $this->backgroundColor?>',
            scaleMode:'<?php echo $this->scaleMode?>',
            configuration:"<?php echo $this->configuration ?>"
        };


       var parameters = {
                    allowFullScreen: <?php echo $this->allowFullScreen?>     
       };


       var attributes = {
                  id:"<?php echo $this->attr_id ?>" ,  //not to be confused with the id of the div that the video will replace,namely
                                                                                     //the second swfobject.embedSWF argument.This one  is used in attributes argument,defaults to 'smp'.
                  name:"<?php echo $this->name?>"
                };




 // Get the page query string and retrieve page params
                var pageOptions = {}, queryString = window.location.search;
                if (queryString) {
                    queryString = queryString.substring(1);
                    pageOptions = $.fn.strobemediaplayback.parseQueryString(queryString);
                }

                options = $.extend({}, options, pageOptions);

  // Uncomment to trigger sniffing of Flash and HTML5 Video capabilities that decides which
  // format is used.In this case any useHTML5 setting will be ignored.
  
      //options = $.fn.adaptiveexperienceconfigurator.adapt(options);

                // Now we are ready to generate the video tags
                //You can set the id of the div in widget parameters,default is 'strobemediaplayback'.
                //This div will be replaced by the video.

               $("#<?php echo $this->id ?>").strobemediaplayback(options,parameters,attributes);
           
            });


            </script>
		

<!--
This is the div for the title of the loaded content : the value of  src_title parameter
 corresponding to the src parameter that you set on the widget,or,if a playlist item is loaded,
it is simply the title of the playlist item.
-->
<div id='title' >
    <h1>
    <?php if(isset($_GET['title'])){echo $_GET['title'].'<br>';} else {echo $this->src_title.'<br>';}?>
    </h1>
</div>
<!-- This is the div that wraps the player.If flash is disabled,alternative content will be displayed.
.For multiple instances of the player,you can set up divs with different ids and then call the widget
 multiple times setting the id paramerer for each call.
-->
<div id="<?php echo $this->id ?>">
    <h1>Flash Player Is Not Installed.</h1><br>
    <h3><?php echo $this->altHtmlContent ?></h3><br>
    <a href="http://www.adobe.com/go/getflashplayer">
        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
    </a>
</div>
<br><br>
<!-- If a playlist is set,the markup will be inserted in this div-->
<div id="playlist">
 <?php if ($this->playlistLinks != null)  echo $this->playlistMarkup();?>
</div>






