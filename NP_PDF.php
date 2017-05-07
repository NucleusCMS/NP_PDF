<?php

global $DIR_PLUGINS, $manager;
define('FPDF_FONTPATH',$DIR_PLUGINS.'pdf/font/');
if($manager->pluginInstalled('NP_Wikistyle')) require_once($DIR_PLUGINS.'NP_Wikistyle.php');
include($DIR_PLUGINS.'pdf/html2pdf.php');


// patch for non-XE editions
if (!is_callable('fancyLink')){
  function fancyLink($id){
    global $CONF;
    return $CONF['IndexURL'].createItemLink($id);
  }
}

class NP_PDF extends NucleusPlugin {

	function getName() {	return 'PDF'; 	}
	function getAuthor()  { return 'Radek HULAN'; 	}
	function getURL() {		return 'http://hulan.info/blog/'; }
	function getVersion() {	return '0.1j'; }
	function getDescription() { 
		return 'Template var to add a PDF-friendly version of your article. Use &lt;%PDF%&gt; inside your detailed (item) template';
	}
	
	function supportsFeature($feature) {
		switch($feature) {
			case 'SqlTablePrefix':
				return 1;
			default:
				return 0;
		}
	}

	function install() {
		$this->createOption('pdftext','Text to display as a link?','text','[PDF]');
		$this->createOption('bold','Support italics and bold text?','yesno','no');
		$this->createOption('imgembed','Support embedded images?','yesno','no');
		$this->createOption('imglinked','Support linked images?','yesno','yes');
		$this->createOption('iconvuse','Use iconv?','yesno','no');
		$this->createOption('iconvinput','Iconv input encoding','text','iso-8859-2');
		$this->createOption('iconvoutput','Iconv output encoding','text','cp1250');
		$this->createOption('directory','Subdirectory under media dir to create files (must end with a slash)?','text','pdf/');
		$this->createOption('delete','Delete temporary files after X minutes','text','60');
	}

  function convert($s){
    static $useiconv=2, $from, $to;
    if ($useiconv==2) {
      $useiconv=($this->getOption('iconvuse')=='yes');
      $from=$this->getOption('iconvinput');
      $to=$this->getOption('iconvoutput');
    }
    if ($useiconv) return iconv($from,$to,$s); else return $s;
  }
  
  function _redirect(){
    $url = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    header("Location: $url");
    $url = htmlspecialchars($url);
    die("Redirected: <a href=\"$url\">$url</a>");
  }	

  function iso2ascii($s){
     $iso="áèïéìíåµòó¡¦»úùý¾äëöüÁÈÏÉÌÍÅ¥ÒÓØ¡¦ÚÙÝ®ÄËÖÜ";
     $asc="acdeeillnorstuuyzaeouACDEEILLNORSTUUYZAEOU";
    return strtr($s,$iso,$asc);
  }

	function makeFileName($title) {
		$title = $this->iso2ascii(strip_tags(trim($title)));
		preg_match_all('/[a-zA-Z0-9]+/', $title, $nt);
		return implode('-',$nt[0]);
	}

  function doAction($type) {
    global $CONF, $DIR_MEDIA ,$manager;
    $itemid = intRequestVar('itemid');

    $query=mysql_query('select ibody as body, imore as more, ititle as title, UNIX_TIMESTAMP(itime) as time, iauthor as member from '.sql_table('item').' where inumber='.strval($itemid));
    if (!$row=mysql_fetch_object($query)) $this->_redirect();
    
    $row->body = stripslashes($row->body);
    $row->more = stripslashes($row->more);

if($manager->pluginInstalled('NP_Wikistyle')){
	$wi = new NP_Wikistyle;
    $wi->convert_wikitag(&$row->body);
    $wi->convert_wikitag($row->more);
}

    $mquery = mysql_query("SELECT mrealname, mname FROM ".sql_table('member')." WHERE mnumber = ".$row->member);
    $member = mysql_fetch_object($mquery);

    // change some tags into pseudo-tags
    $str=array(
      '[b]' => '<b>',
      '[/b]' => '</b>',
      '<br />' => '<br>',
      '<hr />' => '<hr>',
      '[i]' => '<i>',
      '[/i]' => '</i>',
      '[r]' => '<red>',
      '[/r]' => '</red>',
      '[l]' => '<blue>',
      '[/l]' => '</blue>',
      '&#8220;' => '"',
      '&#8221;' => '"',
      '&#8222;' => '"',
      '&#8230;' => '...',
      '&#8217;' => '\''
    );
		foreach ($str as $from => $to) {
		  $row->body = str_replace($from,$to,$row->body);
		  $row->more = str_replace($from,$to,$row->more);
		}
		/* images embedded */
		if ($this->getOption('imgembed')=='yes'){
		  $row->body = preg_replace('/<%image\((.*?)\|(.*?)\|(.*?)\|(.*?)%>/','<img src="'.$CONF['MediaURL'].strval($row->member).'/'.'$1" width="$2" height="$3">',$row->body);
		  $row->more = preg_replace('/<%image\((.*?)\|(.*?)\|(.*?)\|(.*?)%>/','<img src="'.$CONF['MediaURL'].strval($row->member).'/'.'$1" width="$2" height="$3">',$row->more);
		}
		/* images linked */
		if ($this->getOption('imglinked')=='yes'){
		  $row->body = preg_replace('/<%image\((.*?)\|(.*?)\|(.*?)\|(.*?)\)%>/','<br> * <red>Linked image: <a href="'.$CONF['MediaURL'].strval($row->member).'/'.'$1">$4</a></red>',$row->body);
		  $row->more = preg_replace('/<%image\((.*?)\|(.*?)\|(.*?)\|(.*?)\)%>/','<br> * <red>Linked image: <a href="'.$CONF['MediaURL'].strval($row->member).'/'.'$1">$4</a></red>',$row->more);
		}

		/* remove Nucleus custom tags */
		$row->body = preg_replace('/<%(.*?)%>/','',$row->body);
		$row->more = preg_replace('/<%(.*?)%>/','',$row->more);

		/* remove NP_Poll tags */
		$row->body = preg_replace('/\?\+\+(.*?)\+\+\?/','',$row->body);
		$row->more = preg_replace('/\?\+\+(.*?)\+\+\?/','',$row->more);
		$row->body = preg_replace('/\!\+\+(.*?)\+\+\!/','',$row->body);
		$row->more = preg_replace('/\!\+\+(.*?)\+\+\!/','',$row->more);

    $articleurl=fancyLink($itemid);
    $pdf=new PDF('P','mm','A4',stripslashes($row->title),$articleurl,false);
    $pdf->Open();
    $pdf->SetCompression(false);
    $pdf->SetCreator("Nucleus CMS :: script by Radek HULAN, http://hulan.info/blog/");
    $pdf->SetDisplayMode('real');
//    $pdf->SetTitle($this->convert(stripslashes($row->title)));
    $pdf->SetTitle($pdf->_unicode(stripslashes($row->title)));
    $pdf->SetAuthor($this->convert($CONF['SiteName']));
    $pdf->AddPage();

    // face
    $pdf->PutMainTitle($this->convert(stripslashes($row->title)));
    $pdf->PutMinorHeading('Article URI: ');
    $pdf->PutMinorTitle($articleurl,$articleurl);
    $pdf->PutMinorHeading('Author: ');
//  $pdf->PutMinorTitle($this->convert($member->mrealname));
    $pdf->PutMinorTitle($this->convert($member->mname));
    $pdf->PutMinorHeading('Site URI: ');
    $pdf->PutMinorTitle($CONF['IndexURL'],$CONF['IndexURL']);
    $pdf->PutMinorHeading("Published: ");
    $pdf->PutMinorTitle(date("F j, Y, g:i a"));
    $pdf->PutLine();
    $pdf->Ln(5);

    // body
    $bi=($this->getOption('bold')=='yes');
    $pdf->WriteHTML($this->convert($row->body),$bi);
    $pdf->WriteHTML($this->convert($row->more),$bi);

    //save and redirect
//    $filename=$this->getOption('directory').$this->makeFileName($row->title).'.pdf';
	
    $filename=$this->getOption('directory').sprintf("%06s", strval($itemid)).'.pdf';
    $real=$DIR_MEDIA.$filename;
    $http=$CONF['MediaURL'].$filename;
    $pdf->Output($real);
    header("Location: $http");

    // cleanup
    $dir=$DIR_MEDIA.$this->getOption('directory');
    $files=opendir($dir);
    $minutes=intval($this->getOption('delete'));
    while ( false !== ($filename = readdir($files))) {
      if (!(strpos($filename,'.pdf')===false)){
        // delete old temp files
        $time=filectime($dir.$filename);
        if (!($time===false) && $time>0) if ($time+$minutes*60<time()) unlink($dir.$filename);
      }
    }
    // stop processing
    exit;
  }

	function doTemplateVar(&$item) {
		global $CONF;
    $url = $CONF['IndexURL'].'action.php?action=plugin&amp;name=PDF&amp;itemid='.$item->itemid;
    echo '<a href="'.$url.'" target="_blank">'.$this->getOption('pdftext')."</a>";
	}

} 
