<?php

/***************************/ 
/* Radek HULAN             */
/* http://hulan.info/blog/ */
/***************************/ 

require('mbfpdf.php');

function hex2dec($color = "#000000"){
    $tbl_color = array();
    $tbl_color['R']=hexdec(substr($color, 1, 2));
    $tbl_color['G']=hexdec(substr($color, 3, 2));
    $tbl_color['B']=hexdec(substr($color, 5, 2));
    return $tbl_color;
}

function px2mm($px){return $px*25.4/72;}

function txtentities($html){
//    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = get_html_translation_table(HTML_SPECIALCHARS);
    $trans = array_flip($trans);
    return strtr($html, $trans);
}

class PDF extends MBFPDF
{

var $B;
var $I;
var $U;
var $HREF;
var $fontList;
var $issetfont;
var $issetcolor;

function PDF($orientation='P',$unit='mm',$format='A4',$_title,$_url,$_debug=false)
{
define ('_OUTPUTCHARSET', 'SJIS');

    $this->MBFPDF($orientation,$unit,$format);
    $this->B=0;
    $this->I=0;
    $this->U=0;
    $this->HREF='';
    $this->PRE=false;
    $this->AddMBFont(GOTHIC ,'SJIS');
    $this->AddMBFont(PGOTHIC,'SJIS');
    $this->AddMBFont(MINCHO ,'SJIS');
    $this->AddMBFont(PMINCHO,'SJIS');
    $this->AddMBFont(KOZMIN ,'SJIS');
    $this->AddFont('Courier');
    $this->AddFont('Times');
    $this->SetFont(PGOTHIC,'',10);

//    $this->SetLineWidth(1);

    $this->fontlist=array(GOTHIC,PGOTHIC,MINCHO,PMINCHO,KOZMIN,"Times","Courier");
    $this->issetfont=false;
    $this->issetcolor=false;
    $this->articletitle=$_title;
    $this->articleurl=$_url;
    $this->debug=$_debug;
    $this->AliasNbPages();
}

function WriteHTML($html,$bi)
{   //remove all unsupported tags
    $this->bi=$bi;
    if ($bi)    
      $html=strip_tags($html,"<a><img><p><br><br><font><tr><blockquote><h1><h2><h3><h4><pre><red><blue><ul><ol><li><hr><b><i><u><strong><em>"); 
    else
      $html=strip_tags($html,"<a><img><p><br><font><tr><blockquote><h1><h2><h3><h4><pre><red><blue><ul><ol><li><hr>"); 
//    $html=str_replace("\n",' ',$html); //replace carriage returns by spaces
    $html=str_replace("\n",'',$html); //replace carriage returns by spaces
     
    // debug
    if ($this->debug){ echo $html; exit; }
    
    $html = str_replace('&trade;','ÅE',$html);
    $html = str_replace('&copy;','©',$html);
    $html = str_replace('&euro;','Ä',$html);
   
    $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    $skip=false;
    	$this->ullevel = 0;
    	$this->ollevel = 0;
    foreach($a as $i=>$e){
		$e = mb_convert_encoding($e, _OUTPUTCHARSET, _CHARSET);
        if (!$skip) {
        if($this->HREF) $e=str_replace("\n","",str_replace("\r","",$e));
        if($i%2==0)
        {
            // new line
            if($this->PRE) $e=str_replace("\r","\n",$e); else $e=str_replace("\r","",$e);
            //Text
            if($this->HREF) {
              $this->PutLink($this->HREF,$e);
              $skip=true;
            } else {
//            $this->Write(5,stripslashes(txtentities($e)));
            $this->SetRightMargin(20);
              $this->Write(5,txtentities($e));
//            $this->Write(0,mb_convert_encoding(stripslashes(txtentities($e)), _OUTPUTCHARSET, _CHARSET));
            }
        } else {
            //Tag
            if (substr(trim($e),0,1)=='/'){
            	$close_tag = strtoupper(substr($e,strpos($e,'/')));
            	if($close_tag == '/UL'){
            		$this->ullevel--;
            		if($this->ollevel)	$this->numflag = 1;
            	}
            	if($close_tag == '/OL'){
//            		$this->Write(5,'99999'.$this->ulcnt[$this->ullevel] );
            		unset($this->numcnt[$this->ollevel]);
            		 $this->ollevel--;
            	}
                $this->CloseTag($close_tag);
            } else {
                //Extract attributes
                $a2=explode(' ',$e);
                $tag=strtoupper(array_shift($a2));
                $attr=array();
                foreach($a2 as $v) if(ereg('^([^=]*)=["\']?([^"\']*)["\']?$',$v,$a3)) {
                  $attr[strtoupper($a3[1])]=$a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
        } else {
          $this->HREF='';
          $skip=false;
        }
    }
}

function OpenTag($tag,$attr)
{
    //Opening tag
    switch($tag){
        case 'STRONG':
        case 'B':
            if ($this->bi)            
              $this->SetStyle('B',true);
            else
              $this->SetStyle('U',true);
            break;
        case 'H1':
            $this->Ln(5);
            $this->SetTextColor(150,0,0);
            $this->SetFontSize(22);
            if ($this->bi) $this->SetStyle('B',true);
            break;
        case 'H2':
            $this->Ln(5);
            $this->SetFontSize(18);
            if ($this->bi) $this->SetStyle('B',true);
            break;
        case 'H3':
            $this->Ln(5);
            $this->SetFontSize(16);
            if ($this->bi) $this->SetStyle('B',true);
            break;
        case 'H4':
            $this->Ln(5);
            $this->SetTextColor(102,0,0);
            $this->SetFontSize(14);
            if ($this->bi) $this->SetStyle('B',true);
            break;
        case 'PRE':
            $this->SetFont(GOTHIC,'',12);
            $this->SetFontSize(12);
            $this->SetStyle('B',false);
            $this->SetStyle('I',false);
            $this->PRE=true;
            break;
        case 'RED':
            $this->SetTextColor(255,0,0);
            break;
        case 'BLOCKQUOTE':
            $this->mySetTextColor(100,0,45);
            $this->Ln(3);
            break;
        case 'BLUE':
            $this->SetTextColor(0,0,255);
            break;
        case 'I':
        case 'EM':
            if ($this->bi) $this->SetStyle('I',true);
            break;
        case 'U':
            $this->SetStyle('U',true);
            break;
        case 'A':
            $this->HREF=$attr['HREF'];
            break;
        case 'IMG':
            if(isset($attr['SRC']) and (isset($attr['WIDTH']) or isset($attr['HEIGHT']))) {
                if(!isset($attr['WIDTH']))
                    $attr['WIDTH'] = 0;
                if(!isset($attr['HEIGHT']))
                    $attr['HEIGHT'] = 0;
                $this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
                $this->Ln(3);
            }
            break;
        case 'UL':
        	$this->ullevel++;
        	$this->numflag = 0;
            break;
        case 'OL':
        	$this->ollevel++;
        	$this->numflag = 1;
            break;
        case 'LI':
            $this->Ln(0);
            $cx = 10 + ($this->ullevel+$this->ollevel)*10;
            $prestr = ' * ';
        	if($this->numflag){
        		$this->numcnt[$this->ollevel]++;
            	$prestr = $this->numcnt[$this->ollevel].'. ';
        	}
            $prewth = $this->GetStringWidth($prestr);
            $precx = $cx - $prewth;
            $this->SetLeftMargin($precx);
//            $this->SetTextColor(190,0,0);
            $this->Write(5,$prestr);
            $this->SetLeftMargin($cx);
//          $lispace = str_repeat("    ",$this->ullevel+$this->ollevel);
//            $this->Write(5,$lispace.' * ');
            $this->mySetTextColor(-1);
            break;
        case 'TR':
            $this->Ln(7);
            $this->PutLine();
            break;
        case 'BR':
            $this->Ln(6);
            break;
        case 'P':
            $this->Ln(10);
            break;
        case 'HR':
            $this->PutLine();
            break;
        case 'FONT':
            if (isset($attr['COLOR']) and $attr['COLOR']!='') {
                $coul=hex2dec($attr['COLOR']);
                $this->mySetTextColor($coul['R'],$coul['G'],$coul['B']);
                $this->issetcolor=true;
            }
            if (isset($attr['FACE']) and in_array(strtolower($attr['FACE']), $this->fontlist)) {
                $this->SetFont(strtolower($attr['FACE']));
                $this->issetfont=true;
            }
            break;
    }
}

function CloseTag($tag)
{   
    //Closing tag
    if ($tag='H1' || $tag='H2' || $tag='H3' || $tag='H4'){
      $this->Ln(3);
      $this->SetFont(PMINCHO,'',12);
      $this->SetFontSize(12);
      $this->SetStyle('U',false);
      $this->SetStyle('B',false);
      $this->mySetTextColor(-1);
    }
    if ($tag='PRE'){
      $this->SetFont(PMINCHO,'',12);
      $this->SetFontSize(12);
      $this->PRE=false;
    }
    if ($tag='RED' || $tag='BLUE') $this->mySetTextColor(-1);
    if ($tag='BLOCKQUOTE'){
      $this->mySetTextColor(0,0,0);
      $this->Ln(3);
    }
    if ($tag='LI'){
      $this->Ln(0);
          $this->SetLeftMargin(10);
    }
    if($tag=='STRONG') $tag='B';
    if($tag=='EM') $tag='I';
    if((!$this->bi) && $tag=='B') $tag='U';
    if($tag=='B' or $tag=='I' or $tag=='U') $this->SetStyle($tag,false);
    if($tag=='A') $this->HREF='';
    if($tag=='FONT'){
        if ($this->issetcolor==true) {
            $this->SetTextColor(0,0,0);
        }
        if ($this->issetfont) {
            $this->SetFont('Times','',12);
            $this->issetfont=false;
        }
    }
}

function Footer()
{
    //Go to 1.5 cm from bottom
    $this->SetY(-15);
    //Select Arial italic 8
    $this->SetFont('Times','',8);
    //Print centered page number
    $this->SetTextColor(0,0,0);
    $this->Cell(0,4,'Page '.$this->PageNo().'/{nb}',0,1,'C');
    $this->SetTextColor(0,0,180);
    $this->Cell(0,4,'PDF export created by Nucleus, GNU PHP/MySQL CMS system',0,0,'C',0,'http://hulan.info/blog/item/nucleus-cms-extreme-edition-3-0-rc');
    $this->mySetTextColor(-1);
}

function Header()
{
    //Select Arial bold 15
    $this->SetTextColor(0,0,0);
//    $this->SetFont('Times','',10);
    $this->articletitle = mb_convert_encoding($this->articletitle, _OUTPUTCHARSET, _CHARSET);
//  $this->Cell(0,10,$this->articletitle,0,0,'C');
//    $this->MultiCell(0,5,$this->articletitle,1,"C",0);
//    $this->Ln(2);
//    $this->SetFont('Times','',10);
//    $this->Cell(0,10,$this->articleurl,0,0,'C');
//    $this->Ln(7);
//    $this->Line($this->GetX(),$this->GetY(),$this->GetX()+187,$this->GetY());
    //Line break
//    $this->Ln(2);
    $this->SetFont(PMINCHO,'',12);
    $this->mySetTextColor(-1);
}

function SetStyle($tag,$enable)
{
    $this->$tag+=($enable ? 1 : -1);
    $style='';
    foreach(array('B','I','U') as $s) if($this->$s>0) $style.=$s;
    $this->SetFont('',$style);
}

function PutLink($URL,$txt)
{   
    //Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->mySetTextColor(-1);
}

function PutLine()
{   
  $this->Ln(2);
  $this->Line($this->GetX(),$this->GetY(),$this->GetX()+187,$this->GetY());
  $this->Ln(3);
}


function mySetTextColor($r,$g=0,$b=0){
  static $_r=0, $_g=0, $_b=0;
  if ($r==-1) 
    $this->SetTextColor($_r,$_g,$_b);
  else {
    $this->SetTextColor($r,$g,$b);
    $_r=$r;
    $_g=$g;
    $_b=$b;
  }
    
}

function PutMainTitle($title){
//	$title = mb_strimwidth($title,0, 27, "...", _CHARSET);
	$title = mb_convert_encoding($title, _OUTPUTCHARSET, _CHARSET);
//  if (strlen($title)>55) $title=substr($title,0,55)."...";
  $this->SetTextColor(33,32,95);
  $this->SetFontSize(20);
  $this->SetFillColor(255,204,120);
//  $this->Cell(0,20,$title,1,1,"C",1);
  $this->MultiCell(0,15,$title,1,"C",1);
  $this->SetFillColor(255,255,255);
  $this->SetFontSize(12);
  $this->Ln(1);
}

function PutMinorHeading($title){
	$this->headtitle = $title;
//  $this->SetFontSize(10);
  $this->SetFont('Times','',10);
//  $this->Cell(0,5,$title,0,1,"R");
//    $char_width = 27 - $this->GetStringWidth($title);
//    $this->SetX($char_width);
  $this->Write(5,$title);
//  $this->SetFontSize(12);
  $this->SetFont(PMINCHO,'',12);
}

function PutMinorTitle($title,$url=''){
//  $title=str_replace('http://','',$title);
  if (strlen($title)>70) if (!(strrpos($title,'/')==false)) $title=substr($title,strrpos($title,'/')+1);
  $title=substr($title,0,70);
//  $this->SetFontSize(16);
  $this->SetFont('Times','',10);
  if ($url!='') {
    $this->SetStyle('U',false);
    $this->SetTextColor(0,0,180);
//    $this->Cell(0,6,$title,0,1,"R",0,$url);
    $this->SetX('30');
    $this->Write(5,$title,$url);
    $this->SetTextColor(0,0,0);
    $this->SetStyle('U',false);
  } else { 
//    $title = mb_convert_encoding($title, _OUTPUTCHARSET, _CHARSET);
//    $this->SetFont(PMINCHO,'',10);
//    $this->Cell(0,6,$title,0,1,"R",0);
    $this->SetX('30');
    $this->Write(5,$title);
  }
//  $this->SetFontSize(12);
  $this->SetFont(PMINCHO,'',12);
  $this->Ln(4);
}

}
?>
