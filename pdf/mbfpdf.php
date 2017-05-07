<?php
//-------------------------------------------------------------------------
// Multi-Byte FPDF                                            version: 1.0b
//-------------------------------------------------------------------------
// Usage: AddMBFont(FontName,Encoding);
//
// Example:
//    Chinese:  AddMBFont(BIG5  ,'BIG5');
//    Japanese: AddMBFont(GOTHIC,'SJIS');

require('fpdf.php');            // Original Class

// Short Font Name ------------------------------------------------------------
// For Acrobat Reader (Windows, MacOS, Linux, Solaris etc)
DEFINE("BIG5",    'MSungStd-Light-Acro');
DEFINE("GB",      'STSongStd-Light-Acro');
DEFINE("KOZMIN",  'KozMinPro-Regular-Acro');
// For Japanese Windows Only
DEFINE("GOTHIC",  'MS-Gothic');
DEFINE("PGOTHIC", 'MS-PGothic');
DEFINE("UIGOTHIC",'MS-UIGothic');
DEFINE("MINCHO",  'MS-Mincho');
DEFINE("PMINCHO", 'MS-PMincho');

class MBFPDF extends FPDF
{

// Encoding & CMap List (CMap information from Acrobat Reader Resource/CMap folder)
var $MBCMAP = array (
'BIG5' => array ('CMap'=>'ETenms-B5-H'   ,'Ordering'=>'CNS1'  ,'Supplement'=>0),
'GB' => array ('CMap'=>'GBKp-EUC-H'    ,'Ordering'=>'GB1'   ,'Supplement'=>2),
'SJIS'=> array ('CMap'=>'90msp-RKSJ-H'  ,'Ordering'=>'Japan1','Supplement'=>2),
'UNIJIS' => array ('CMap'=>'UniJIS-UTF16-H','Ordering'=>'Japan1','Supplement'=>5),
'EUC-JP' => array ('CMap'=>'EUC-H'         ,'Ordering'=>'Japan1','Supplement'=>1));
// EUC-JP has *problem* of underline and not support half-pitch characters.

var $MBTTFDEF = array(
'MSungStd-Light-Acro' => array (
    'ut'=>40  ,'up'=>-120,'cw'=>array (
    ' '=>250  ,'!'=>250  ,'\"'=>408 ,'#'=>668  ,'$'=>490  ,'%'=>875  ,'&'=>698  ,
    '\''=>250 ,'('=>240  ,')'=>240  ,'*'=>417  ,'+'=>667  ,','=>250  ,'-'=>313  ,
    '.'=>250  ,'/'=>520  ,'0'=>500  ,'1'=>500  ,'2'=>500  ,'3'=>500  ,'4'=>500  ,
    '5'=>500  ,'6'=>500  ,'7'=>500  ,'8'=>500  ,'9'=>500  ,':'=>250  ,';'=>250  ,
    '<'=>667  ,'='=>667  ,'>'=>667  ,'?'=>396  ,'@'=>921  ,'A'=>677  ,'B'=>615  ,
    'C'=>719  ,'D'=>760  ,'E'=>625  ,'F'=>552  ,'G'=>771  ,'H'=>802  ,'I'=>354  ,
    'J'=>354  ,'K'=>781  ,'L'=>604  ,'M'=>927  ,'N'=>750  ,'O'=>823  ,'P'=>563  ,
    'Q'=>823  ,'R'=>729  ,'S'=>542  ,'T'=>698  ,'U'=>771  ,'V'=>729  ,'W'=>948  ,
    'X'=>771  ,'Y'=>677  ,'Z'=>635  ,'['=>344  ,'\\'=>520 ,']'=>344  ,'^'=>469  ,
    '_'=>500  ,'`'=>250  ,'a'=>469  ,'b'=>521  ,'c'=>427  ,'d'=>521  ,'e'=>438  ,
    'f'=>271  ,'g'=>469  ,'h'=>531  ,'i'=>250  ,'j'=>250  ,'k'=>458  ,'l'=>240  ,
    'm'=>802  ,'n'=>531  ,'o'=>500  ,'p'=>521  ,'q'=>521  ,'r'=>365  ,'s'=>333  ,
    't'=>292  ,'u'=>521  ,'v'=>458  ,'w'=>677  ,'x'=>479  ,'y'=>458  ,'z'=>427  ,
    '{'=>480  ,'|'=>496  ,'}'=>480  ,'~'=>667  )),

'STSongStd-Light-Acro' => array (
    'ut'=>40  ,'up'=>-120,'cw'=>array (
    ' '=>207  ,'!'=>270  ,'\"'=>342 ,'#'=>467  ,'$'=>462  ,'%'=>797  ,'&'=>710  ,
    '\''=>239 ,'('=>374  ,')'=>374  ,'*'=>423  ,'+'=>605  ,','=>238  ,'-'=>375  ,
    '.'=>238  ,'/'=>334  ,'0'=>462  ,'1'=>462  ,'2'=>462  ,'3'=>462  ,'4'=>462  ,
    '5'=>462  ,'6'=>462  ,'7'=>462  ,'8'=>462  ,'9'=>462  ,':'=>238  ,';'=>238  ,
    '<'=>605  ,'='=>605  ,'>'=>605  ,'?'=>344  ,'@'=>748  ,'A'=>684  ,'B'=>560  ,
    'C'=>695  ,'D'=>739  ,'E'=>563  ,'F'=>511  ,'G'=>729  ,'H'=>793  ,'I'=>318  ,
    'J'=>312  ,'K'=>666  ,'L'=>526  ,'M'=>896  ,'N'=>758  ,'O'=>772  ,'P'=>544  ,
    'Q'=>772  ,'R'=>628  ,'S'=>465  ,'T'=>607  ,'U'=>753  ,'V'=>711  ,'W'=>972  ,
    'X'=>647  ,'Y'=>620  ,'Z'=>607  ,'['=>374  ,'\\'=>333 ,']'=>374  ,'^'=>606  ,
    '_'=>500  ,'`'=>239  ,'a'=>417  ,'b'=>503  ,'c'=>427  ,'d'=>529  ,'e'=>415  ,
    'f'=>264  ,'g'=>444  ,'h'=>518  ,'i'=>241  ,'j'=>230  ,'k'=>495  ,'l'=>228  ,
    'm'=>793  ,'n'=>527  ,'o'=>524  ,'p'=>524  ,'q'=>504  ,'r'=>338  ,'s'=>336  ,
    't'=>277  ,'u'=>517  ,'v'=>450  ,'w'=>652  ,'x'=>466  ,'y'=>452  ,'z'=>407  ,
    '{'=>370  ,'|'=>258  ,'}'=>370  ,'~'=>605  )),

'KozMinPro-Regular-Acro' => array (
    'ut'=>40  ,'up'=>-120,'cw'=>array (
    ' '=>278  ,'!'=>299  ,'\"'=>353 ,'#'=>614  ,'$'=>614  ,'%'=>721  ,'&'=>735  ,
    '\''=>216 ,'('=>323  ,')'=>323  ,'*'=>449  ,'+'=>529  ,','=>219  ,'-'=>306  ,
    '.'=>219  ,'/'=>453  ,'0'=>614  ,'1'=>614  ,'2'=>614  ,'3'=>614  ,'4'=>614  ,
    '5'=>614  ,'6'=>614  ,'7'=>614  ,'8'=>614  ,'9'=>614  ,':'=>219  ,';'=>219  ,
    '<'=>529  ,'='=>529  ,'>'=>529  ,'?'=>486  ,'@'=>744  ,'A'=>646  ,'B'=>604  ,
    'C'=>617  ,'D'=>681  ,'E'=>567  ,'F'=>537  ,'G'=>647  ,'H'=>738  ,'I'=>320  ,
    'J'=>433  ,'K'=>637  ,'L'=>566  ,'M'=>904  ,'N'=>710  ,'O'=>716  ,'P'=>605  ,
    'Q'=>716  ,'R'=>623  ,'S'=>517  ,'T'=>601  ,'U'=>690  ,'V'=>668  ,'W'=>990  ,
    'X'=>681  ,'Y'=>634  ,'Z'=>578  ,'['=>316  ,'\\'=>614 ,']'=>316  ,'^'=>529  ,
    '_'=>500  ,'`'=>387  ,'a'=>509  ,'b'=>566  ,'c'=>478  ,'d'=>565  ,'e'=>503  ,
    'f'=>337  ,'g'=>549  ,'h'=>580  ,'i'=>275  ,'j'=>266  ,'k'=>544  ,'l'=>276  ,
    'm'=>854  ,'n'=>579  ,'o'=>550  ,'p'=>578  ,'q'=>566  ,'r'=>410  ,'s'=>444  ,
    't'=>340  ,'u'=>575  ,'v'=>512  ,'w'=>760  ,'x'=>503  ,'y'=>529  ,'z'=>453  ,
    '{'=>326  ,'|'=>380  ,'}'=>326  ,'~'=>387  )
),

'MS-Gothic' => array (
    'ut'=>74  ,'up'=>-66 ,'cw'=>array (
    ' '=>500  ,'!'=>500  ,'\"'=>500 ,'#'=>500  ,'$'=>500  ,'%'=>500  ,'&'=>500  ,
    '\''=>500 ,'('=>500  ,')'=>500  ,'*'=>500  ,'+'=>500  ,','=>500  ,'-'=>500  ,
    '.'=>500  ,'/'=>500  ,'0'=>500  ,'1'=>500  ,'2'=>500  ,'3'=>500  ,'4'=>500  ,
    '5'=>500  ,'6'=>500  ,'7'=>500  ,'8'=>500  ,'9'=>500  ,':'=>500  ,';'=>500  ,
    '<'=>500  ,'='=>500  ,'>'=>500  ,'?'=>500  ,'@'=>500  ,'A'=>500  ,'B'=>500  ,
    'C'=>500  ,'D'=>500  ,'E'=>500  ,'F'=>500  ,'G'=>500  ,'H'=>500  ,'I'=>500  ,
    'J'=>500  ,'K'=>500  ,'L'=>500  ,'M'=>500  ,'N'=>500  ,'O'=>500  ,'P'=>500  ,
    'Q'=>500  ,'R'=>500  ,'S'=>500  ,'T'=>500  ,'U'=>500  ,'V'=>500  ,'W'=>500  ,
    'X'=>500  ,'Y'=>500  ,'Z'=>500  ,'['=>500  ,'\\'=>500 ,']'=>500  ,'^'=>500  ,
    '_'=>500  ,'`'=>500  ,'a'=>500  ,'b'=>500  ,'c'=>500  ,'d'=>500  ,'e'=>500  ,
    'f'=>500  ,'g'=>500  ,'h'=>500  ,'i'=>500  ,'j'=>500  ,'k'=>500  ,'l'=>500  ,
    'm'=>500  ,'n'=>500  ,'o'=>500  ,'p'=>500  ,'q'=>500  ,'r'=>500  ,'s'=>500  ,
    't'=>500  ,'u'=>500  ,'v'=>500  ,'w'=>500  ,'x'=>500  ,'y'=>500  ,'z'=>500  ,
    '{'=>500  ,'|'=>500  ,'}'=>500  ,'~'=>500  )
),

'MS-PGothic' => array (
    'ut'=>74  ,'up'=>-66 ,'cw'=>array (
    ' '=>305  ,'!'=>219  ,'\"'=>500 ,'#'=>500  ,'$'=>500  ,'%'=>500  ,'&'=>594  ,
    '\''=>203 ,'('=>305  ,')'=>305  ,'*'=>500  ,'+'=>500  ,','=>203  ,'-'=>500  ,
    '.'=>203  ,'/'=>500  ,'0'=>500  ,'1'=>500  ,'2'=>500  ,'3'=>500  ,'4'=>500  ,
    '5'=>500  ,'6'=>500  ,'7'=>500  ,'8'=>500  ,'9'=>500  ,':'=>203  ,';'=>203  ,
    '<'=>500  ,'='=>500  ,'>'=>500  ,'?'=>453  ,'@'=>668  ,'A'=>633  ,'B'=>637  ,
    'C'=>664  ,'D'=>648  ,'E'=>566  ,'F'=>551  ,'G'=>680  ,'H'=>641  ,'I'=>246  ,
    'J'=>543  ,'K'=>598  ,'L'=>539  ,'M'=>742  ,'N'=>641  ,'O'=>707  ,'P'=>617  ,
    'Q'=>707  ,'R'=>625  ,'S'=>602  ,'T'=>590  ,'U'=>641  ,'V'=>633  ,'W'=>742  ,
    'X'=>602  ,'Y'=>590  ,'Z'=>566  ,'['=>336  ,'\\'=>504 ,']'=>336  ,'^'=>414  ,
    '_'=>305  ,'`'=>414  ,'a'=>477  ,'b'=>496  ,'c'=>500  ,'d'=>496  ,'e'=>500  ,
    'f'=>305  ,'g'=>461  ,'h'=>500  ,'i'=>211  ,'j'=>219  ,'k'=>461  ,'l'=>211  ,
    'm'=>734  ,'n'=>500  ,'o'=>508  ,'p'=>496  ,'q'=>496  ,'r'=>348  ,'s'=>461  ,
    't'=>352  ,'u'=>500  ,'v'=>477  ,'w'=>648  ,'x'=>461  ,'y'=>477  ,'z'=>457  ,
    '{'=>234  ,'|'=>234  ,'}'=>234  ,'~'=>414  )
),


'MS-UIGothic' => array (
    'ut'=>74  ,'up'=>-66 ,'cw'=>array (
    ' '=>305  ,'!'=>219  ,'\"'=>500 ,'#'=>500  ,'$'=>500  ,'%'=>500  ,'&'=>594  ,
    '\''=>203 ,'('=>305  ,')'=>305  ,'*'=>500  ,'+'=>500  ,','=>203  ,'-'=>500  ,
    '.'=>203  ,'/'=>500  ,'0'=>500  ,'1'=>500  ,'2'=>500  ,'3'=>500  ,'4'=>500  ,
    '5'=>500  ,'6'=>500  ,'7'=>500  ,'8'=>500  ,'9'=>500  ,':'=>203  ,';'=>203  ,
    '<'=>500  ,'='=>500  ,'>'=>500  ,'?'=>453  ,'@'=>668  ,'A'=>633  ,'B'=>637  ,
    'C'=>664  ,'D'=>648  ,'E'=>566  ,'F'=>551  ,'G'=>680  ,'H'=>641  ,'I'=>246  ,
    'J'=>543  ,'K'=>598  ,'L'=>539  ,'M'=>742  ,'N'=>641  ,'O'=>707  ,'P'=>617  ,
    'Q'=>707  ,'R'=>625  ,'S'=>602  ,'T'=>590  ,'U'=>641  ,'V'=>633  ,'W'=>742  ,
    'X'=>602  ,'Y'=>590  ,'Z'=>566  ,'['=>336  ,'\\'=>504 ,']'=>336  ,'^'=>414  ,
    '_'=>305  ,'`'=>414  ,'a'=>477  ,'b'=>496  ,'c'=>500  ,'d'=>496  ,'e'=>500  ,
    'f'=>305  ,'g'=>461  ,'h'=>500  ,'i'=>211  ,'j'=>219  ,'k'=>461  ,'l'=>211  ,
    'm'=>734  ,'n'=>500  ,'o'=>508  ,'p'=>496  ,'q'=>496  ,'r'=>348  ,'s'=>461  ,
    't'=>352  ,'u'=>500  ,'v'=>477  ,'w'=>648  ,'x'=>461  ,'y'=>477  ,'z'=>457  ,
    '{'=>234  ,'|'=>234  ,'}'=>234  ,'~'=>414  )
),

'MS-Mincho' => array (
    'ut'=>47  ,'up'=>-94 ,'cw'=>array (
    ' '=>500  ,'!'=>500  ,'\"'=>500 ,'#'=>500  ,'$'=>500  ,'%'=>500  ,'&'=>500  ,
    '\''=>500 ,'('=>500  ,')'=>500  ,'*'=>500  ,'+'=>500  ,','=>500  ,'-'=>500  ,
    '.'=>500  ,'/'=>500  ,'0'=>500  ,'1'=>500  ,'2'=>500  ,'3'=>500  ,'4'=>500  ,
    '5'=>500  ,'6'=>500  ,'7'=>500  ,'8'=>500  ,'9'=>500  ,':'=>500  ,';'=>500  ,
    '<'=>500  ,'='=>500  ,'>'=>500  ,'?'=>500  ,'@'=>500  ,'A'=>500  ,'B'=>500  ,
    'C'=>500  ,'D'=>500  ,'E'=>500  ,'F'=>500  ,'G'=>500  ,'H'=>500  ,'I'=>500  ,
    'J'=>500  ,'K'=>500  ,'L'=>500  ,'M'=>500  ,'N'=>500  ,'O'=>500  ,'P'=>500  ,
    'Q'=>500  ,'R'=>500  ,'S'=>500  ,'T'=>500  ,'U'=>500  ,'V'=>500  ,'W'=>500  ,
    'X'=>500  ,'Y'=>500  ,'Z'=>500  ,'['=>500  ,'\\'=>500 ,']'=>500  ,'^'=>500  ,
    '_'=>500  ,'`'=>500  ,'a'=>500  ,'b'=>500  ,'c'=>500  ,'d'=>500  ,'e'=>500  ,
    'f'=>500  ,'g'=>500  ,'h'=>500  ,'i'=>500  ,'j'=>500  ,'k'=>500  ,'l'=>500  ,
    'm'=>500  ,'n'=>500  ,'o'=>500  ,'p'=>500  ,'q'=>500  ,'r'=>500  ,'s'=>500  ,
    't'=>500  ,'u'=>500  ,'v'=>500  ,'w'=>500  ,'x'=>500  ,'y'=>500  ,'z'=>500  ,
    '{'=>500  ,'|'=>500  ,'}'=>500  ,'~'=>500  )
),

'MS-PMincho' => array (
    'ut'=>47  ,'up'=>-94 ,'cw'=>array (
    ' '=>305  ,'!'=>305  ,'\"'=>461 ,'#'=>500  ,'$'=>500  ,'%'=>500  ,'&'=>613  ,
    '\''=>305 ,'('=>305  ,')'=>305  ,'*'=>500  ,'+'=>500  ,','=>305  ,'-'=>500  ,
    '.'=>305  ,'/'=>500  ,'0'=>500  ,'1'=>500  ,'2'=>500  ,'3'=>500  ,'4'=>500  ,
    '5'=>500  ,'6'=>500  ,'7'=>500  ,'8'=>500  ,'9'=>500  ,':'=>305  ,';'=>305  ,
    '<'=>500  ,'='=>500  ,'>'=>500  ,'?'=>500  ,'@'=>727  ,'A'=>664  ,'B'=>621  ,
    'C'=>699  ,'D'=>691  ,'E'=>598  ,'F'=>598  ,'G'=>711  ,'H'=>723  ,'I'=>289  ,
    'J'=>387  ,'K'=>668  ,'L'=>586  ,'M'=>801  ,'N'=>664  ,'O'=>766  ,'P'=>563  ,
    'Q'=>766  ,'R'=>602  ,'S'=>504  ,'T'=>625  ,'U'=>691  ,'V'=>664  ,'W'=>871  ,
    'X'=>656  ,'Y'=>625  ,'Z'=>563  ,'['=>332  ,'\\'=>500 ,']'=>332  ,'^'=>305  ,
    '_'=>305  ,'`'=>305  ,'a'=>453  ,'b'=>500  ,'c'=>465  ,'d'=>500  ,'e'=>473  ,
    'f'=>254  ,'g'=>473  ,'h'=>500  ,'i'=>242  ,'j'=>242  ,'k'=>492  ,'l'=>242  ,
    'm'=>703  ,'n'=>500  ,'o'=>500  ,'p'=>500  ,'q'=>500  ,'r'=>367  ,'s'=>414  ,
    't'=>352  ,'u'=>500  ,'v'=>477  ,'w'=>602  ,'x'=>469  ,'y'=>477  ,'z'=>453  ,
    '{'=>242  ,'|'=>219  ,'}'=>242  ,'~'=>500  )
));


// For Outline, Title, Sub-Title and ETC Multi-Byte Encoding
function _unicode($txt)
{
/*
    if (function_exists('mb_detect_encoding')) {
        if (mb_detect_encoding($txt) != "ASCII") {
            $txt = chr(254).chr(255).mb_convert_encoding($txt,"UTF-16","auto");
        }
    }
*/
        if (_CHARSET != "ASCII") {
            $txt = chr(254).chr(255).mb_convert_encoding($txt,"UTF-16",_CHARSET);
        }
    return $txt;
}

function AddCIDFont($family,$style,$name,$cw,$CMap,$registry,$ut,$up)
{
  $i=count($this->fonts)+1;
  $fontkey=strtolower($family).strtoupper($style);
  $this->fonts[$fontkey] =
        array('i'=>$i,'type'=>'Type0','name'=>$name,'up'=>$up,'ut'=>$ut,'cw'=>$cw,'CMap'=>$CMap,'registry'=>$registry);
}

function AddMBFont($family='',$enc='')
{
    if ($enc == '' || isset($this->MBCMAP[$enc]) == false) {
        die("AddMBFont: ERROR Encoding [$enc] Undefine.");
    }
    if (isset($this->MBTTFDEF[$family])) {
        $ut=$this->MBTTFDEF[$family]['ut'];
        $up=$this->MBTTFDEF[$family]['up'];
        $cw=$this->MBTTFDEF[$family]['cw'];
        $cm=$this->MBCMAP[$enc]['CMap'];
        $od=$this->MBCMAP[$enc]['Ordering'];
        $sp=$this->MBCMAP[$enc]['Supplement'];
        $registry=array('ordering'=>$od,'supplement'=>$sp);
        $this->AddCIDFont($family,''  ,"$family"           ,$cw,$cm,$registry,$ut,$up);
        $this->AddCIDFont($family,'B' ,"$family,Bold"      ,$cw,$cm,$registry,$ut,$up);
        $this->AddCIDFont($family,'I' ,"$family,Italic"    ,$cw,$cm,$registry,$ut,$up);
        $this->AddCIDFont($family,'BI',"$family,BoldItalic",$cw,$cm,$registry,$ut,$up);
    } else {
        die("AddMBFont: ERROR FontName [$family] Undefine.");
    }
}

function GetStringWidth($s)
{
  if($this->CurrentFont['type']=='Type0')
    return $this->GetMBStringWidth($s);
  else
    return parent::GetStringWidth($s);
}

function GetMBStringWidth($s)
{
  //Multi-byte version of GetStringWidth()
  $l=0;
  $cw=&$this->CurrentFont['cw'];
  $japanese = ($this->CurrentFont['registry']['ordering'] == 'Japan1');
  $nb=strlen($s);
  $i=0;
  while($i<$nb)
  {
    $c=$s[$i];
    if(ord($c)<128)
    {
      $l+=$cw[$c];
      $i++;
    }
    else
    {
      $hwkana = ($japanese && ord($c)==142);
      $l+=$hwkana ? 500 : 1000;
      $i+=2;
    }
  }
  return $l*$this->FontSize/1000;
}

// Function Cell override for Encode Change.
function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = 0, $link = '')
{

    $k = $this->k;

    if ($this->y + $h > $this->PageBreakTrigger
        && !$this->InFooter
        && $this->AcceptPageBreak()) {
        $x  = $this->x;
        $ws = $this->ws;
        if ($ws > 0) {
            $this->ws = 0;
            $this->_out('0 Tw');
        }
        $this->AddPage($this->CurOrientation);
        $this->x = $x;
        if ($ws > 0) {
            $this->ws = $ws;
            $this->_out(sprintf('%.3f Tw', $ws * $k));
        }
    } // end if

    if ($w == 0) {
        $w = $this->w - $this->rMargin - $this->x;
    }

    $s          = '';
    if ($fill == 1 || $border == 1) {
        if ($fill == 1) {
            $op = ($border == 1) ? 'B' : 'f';
        } else {
            $op = 'S';
        }
        $s      = sprintf('%.2f %.2f %.2f %.2f re %s ', $this->x * $k, ($this->h - $this->y) * $k, $w * $k, -$h * $k, $op);
    } // end if

    if (is_string($border)) {
        $x     = $this->x;
        $y     = $this->y;
        if (strpos(' ' . $border, 'L')) {
            $s .= sprintf('%.2f %.2f m %.2f %.2f l S ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y+$h)) * $k);
        }
        if (strpos(' ' . $border, 'T')) {
            $s .= sprintf('%.2f %.2f m %.2f %.2f l S ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);
        }
        if (strpos(' ' . $border, 'R')) {
            $s .= sprintf('%.2f %.2f m %.2f %.2f l S ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
        }
        if (strpos(' ' . $border, 'B')) {
            $s .= sprintf('%.2f %.2f m %.2f %.2f l S ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
        }
    } // end if

    if ($txt != '') {
        if ($align == 'R') {
            $dx = $w - $this->cMargin - $this->GetStringWidth($txt);
        }
        else if ($align == 'C') {
            $dx = ($w - $this->GetStringWidth($txt)) / 2;
        }
        else {
            $dx = $this->cMargin;
        }
        $txt    = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
        if ($this->ColorFlag) {
            $s  .= 'q ' . $this->TextColor . ' ';
        }
        $s      .= sprintf('BT %.2f %.2f Td (%s) Tj ET', ($this->x + $dx) * $k, ($this->h - ($this->y + .5 * $h + .3 * $this->FontSize)) * $k, $txt);
        $txt = stripslashes($txt);
        if ($this->underline) {
            $s  .= ' ' . $this->_dounderline($this->x+$dx, $this->y + .5 * $h + .3 * $this->FontSize, $txt);
        }
        if ($this->ColorFlag) {
            $s  .= ' Q';
        }
        if ($link) {
            $this->Link($this->x + $dx, $this->y + .5 * $h - .5 * $this->FontSize, $this->GetStringWidth($txt), $this->FontSize, $link);
        }
    } // end if

    if ($s) {
        $this->_out($s);
    }
    $this->lasth = $h;

    if ($ln > 0) {
        // Go to next line
        $this->y     += $h;
        if ($ln == 1) {
            $this->x = $this->lMargin;
        }
    } else {
        $this->x     += $w;
    }
} // end of the "Cell()" method

function MultiCell($w,$h,$txt,$border=0,$align='L',$fill=0)
{
  if($this->CurrentFont['type']=='Type0')
    $this->MBMultiCell($w,$h,$txt,$border,$align,$fill);
  else
    parent::MultiCell($w,$h,$txt,$border,$align,$fill);
}

function MBMultiCell($w,$h,$txt,$border=0,$align='L',$fill=0)
{
  //Multi-byte version of MultiCell()
  $cw=&$this->CurrentFont['cw'];
  $japanese = ($this->CurrentFont['registry']['ordering'] == 'Japan1');
  if($w==0)
    $w=$this->w-$this->rMargin-$this->x;
  $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
  $s=str_replace("\r",'',$txt);
  $nb=strlen($s);
  if($nb>0 and $s[$nb-1]=="\n")
    $nb--;
  $b=0;
  if($border)
  {
    if($border==1)
    {
      $border='LTRB';
      $b='LRT';
      $b2='LR';
    }
    else
    {
      $b2='';
      if(is_int(strpos($border,'L')))
        $b2.='L';
      if(is_int(strpos($border,'R')))
        $b2.='R';
      $b=is_int(strpos($border,'T')) ? $b2.'T' : $b2;
    }
  }
  $sep=-1;
  $i=0;
  $j=0;
  $l=0;
  $ns=0;
  $nl=1;
  $ascii=true;
  while($i<$nb)
  {
    //Get next character
    $c=$s[$i];
    //Check if ASCII or MB
    $prev_ascii=$ascii;
    $ascii=(ord($c)<128);
    $hwkana = ($japanese && ord($c)==142);
    if($c=="\n")
    {
      //Explicit line break
      if($this->ws>0)
      {
        $this->ws=0;
        $this->_out('0 Tw');
      }
      $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
      $i++;
      $sep=-1;
      $j=$i;
      $l=0;
      $ns=0;
      $nl++;
      if($border and $nl==2)
        $b=$b2;
      continue;
    }
    if(!($ascii && $prev_ascii) && $i != $j)
    {
      $sep=$i;
      $ls=$l;
    }
    elseif($c==' ')
    {
      $sep=$i;
      $ls=$l;
      $ns++;
    }
    $l+=$ascii ? $cw[$c] : $hwkana ? 500 : 1000;
    if($l>$wmax)
    {
      //Automatic line break
      if($sep==-1)
      {
        if($i==$j)
          $i+=$ascii ? 1 : 2;
        if($this->ws>0)
        {
          $this->ws=0;
          $this->_out('0 Tw');
        }
        $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
      }
      else
      {
        if($align=='J')
        {
          if($s[$sep]==' ')
            $ns--;
          if($s[$i-1]==' ')
          {
            $ns--;
            $ls-=$cw[' '];
          }
          $this->ws=($ns>0) ? ($wmax-$ls)/1000*$this->FontSize/$ns : 0;
          $this->_out(sprintf('%.3f Tw',$this->ws*$this->k));
        }
        $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
        $i=($s[$sep]==' ') ? $sep+1 : $sep;
      }
      $sep=-1;
      $j=$i;
      $l=0;
      $ns=0;
      $nl++;
      if($border and $nl==2)
        $b=$b2;
    }
    else
      $i+=$ascii ? 1 : 2;
  }
  //Last chunk
  if($this->ws>0)
  {
    $this->ws=0;
    $this->_out('0 Tw');
  }
  if($border and is_int(strpos($border,'B')))
    $b.='B';
  $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
  $this->x=$this->lMargin;
}

function Write($h,$txt,$link='')
{
  if($this->CurrentFont['type']=='Type0')
    $this->MBWrite($h,$txt,$link);
  else
    parent::Write($h,$txt,$link);
}

function MBWrite($h,$txt,$link)
{
  //Multi-byte version of Write()
  $cw=&$this->CurrentFont['cw'];
  $japanese = ($this->CurrentFont['registry']['ordering'] == 'Japan1');
  $w=$this->w-$this->rMargin-$this->x;
  $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
  $s=str_replace("\r",'',$txt);
  $nb=strlen($s);
  $sep=-1;
  $i=0;
  $j=0;
  $l=0;
  $nl=1;
  while($i<$nb)
  {
    //Get next character
    $c=$s[$i];
    //Check if ASCII or MB
    $ascii=(ord($c)<128);
    $hwkana = ($japanese && ord($c)==142);
    if($c=="\n")
    {
      //Explicit line break
      $this->Cell($w,$h,substr($s,$j,$i-$j),0,2,'',0,$link);
      $i++;
      $sep=-1;
      $j=$i;
      $l=0;
      if($nl==1)
      {
        $this->x=$this->lMargin;
        $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
      }
      $nl++;
      continue;
    }
    if(!$ascii or $c==' ')
      $sep=$i;
    $l+=$ascii ? $cw[$c] : $hwkana ? 500 : 1000;
    if($l>$wmax)
    {
      //Automatic line break
      if($sep==-1 or $i==$j)
      {
        if($this->x>$this->lMargin)
        {
          //Move to next line
          $this->x=$this->lMargin;
          $this->y+=$h;
          $w=$this->w-$this->rMargin-$this->x;
          $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
          $i++;
          $nl++;
          continue;
        }
        if($i==$j)
          $i+=$ascii ? 1 : 2;
        $this->Cell($w,$h,substr($s,$j,$i-$j),0,2,'',0,$link);
      }
      else
      {
        $this->Cell($w,$h,substr($s,$j,$sep-$j),0,2,'',0,$link);
        $i=($s[$sep]==' ') ? $sep+1 : $sep;
      }
      $sep=-1;
      $j=$i;
      $l=0;
      if($nl==1)
      {
        $this->x=$this->lMargin;
        $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
      }
      $nl++;
    }
    else
      $i+=$ascii ? 1 : 2;
  }
  //Last chunk
  if($i!=$j)
    $this->Cell($l/1000*$this->FontSize,$h,substr($s,$j,$i-$j),0,0,'',0,$link);
}

function _putfonts()
{
  $nf=$this->n;
  foreach($this->diffs as $diff)
  {
    //Encodings
    $this->_newobj();
    $this->_out('<</Type /Encoding /BaseEncoding /WinAnsiEncoding /Differences ['.$diff.']>>');
    $this->_out('endobj');
  }
  $mqr=get_magic_quotes_runtime();
  set_magic_quotes_runtime(0);
  foreach($this->FontFiles as $file=>$info)
  {
    //Font file embedding
    $this->_newobj();
    $this->FontFiles[$file]['n']=$this->n;
//    if(defined('FPDF_FONTPATH'))
//      $file=FPDF_FONTPATH.$file;
    $size=filesize($file);
    if(!$size)
      $this->Error('Font file not found');
    $this->_out('<</Length '.$size);
    if(substr($file,-2)=='.z')
      $this->_out('/Filter /FlateDecode');
    $this->_out('/Length1 '.$info['length1']);
    if(isset($info['length2']))
      $this->_out('/Length2 '.$info['length2'].' /Length3 0');
    $this->_out('>>');
    $f=fopen($file,'rb');
    $this->_putstream(fread($f,$size));
    fclose($f);
    $this->_out('endobj');
  }
  set_magic_quotes_runtime($mqr);
  foreach($this->fonts as $k=>$font)
  {
    //Font objects
    $this->_newobj();
    $this->fonts[$k]['n']=$this->n;
    $this->_out('<</Type /Font');
    if($font['type']=='Type0')
      $this->_putType0($font);
    else
    {
      $name=$font['name'];
      $this->_out('/BaseFont /'.$name);
      if($font['type']=='core')
      {
        //Standard font
        $this->_out('/Subtype /Type1');
        if($name!='Symbol' and $name!='ZapfDingbats')
          $this->_out('/Encoding /WinAnsiEncoding');
      }
      else
      {
        //Additional font
        $this->_out('/Subtype /'.$font['type']);
        $this->_out('/FirstChar 32');
        $this->_out('/LastChar 255');
        $this->_out('/Widths '.($this->n+1).' 0 R');
        $this->_out('/FontDescriptor '.($this->n+2).' 0 R');
        if($font['enc'])
        {
          if(isset($font['diff']))
            $this->_out('/Encoding '.($nf+$font['diff']).' 0 R');
          else
            $this->_out('/Encoding /WinAnsiEncoding');
        }
      }
      $this->_out('>>');
      $this->_out('endobj');
      if($font['type']!='core')
      {
        //Widths
        $this->_newobj();
        $cw=&$font['cw'];
        $s='[';
        for($i=32;$i<=255;$i++)
          $s.=$cw[chr($i)].' ';
        $this->_out($s.']');
        $this->_out('endobj');
        //Descriptor
        $this->_newobj();
        $s='<</Type /FontDescriptor /FontName /'.$name;
        foreach($font['desc'] as $k=>$v)
          $s.=' /'.$k.' '.$v;
        $file=$font['file'];
        if($file)
          $s.=' /FontFile'.($font['type']=='Type1' ? '' : '2').' '.$this->FontFiles[$file]['n'].' 0 R';
        $this->_out($s.'>>');
        $this->_out('endobj');
      }
    }
  }
}

function _putType0($font)
{
  //Type0
  $this->_out('/Subtype /Type0');
  $this->_out('/BaseFont /'.$font['name'].'-'.$font['CMap']);
  $this->_out('/Encoding /'.$font['CMap']);
  $this->_out('/DescendantFonts ['.($this->n+1).' 0 R]');
  $this->_out('>>');
  $this->_out('endobj');
  //CIDFont
  $this->_newobj();
  $this->_out('<</Type /Font');
  $this->_out('/Subtype /CIDFontType0');
  $this->_out('/BaseFont /'.$font['name']);
  $this->_out('/CIDSystemInfo <</Registry (Adobe) /Ordering ('.$font['registry']['ordering'].') /Supplement '.$font['registry']['supplement'].'>>');
  $this->_out('/FontDescriptor '.($this->n+1).' 0 R');
  $W='/W [1 [';
  foreach($font['cw'] as $w)
    $W.=$w.' ';
  $this->_out($W.']');
  if($font['registry']['ordering'] == 'Japan1')
    $this->_out(' 231 325 500 631 [500] 326 389 500');
  $this->_out(']');
  $this->_out('>>');
  $this->_out('endobj');
  //Font descriptor
  $this->_newobj();
  $this->_out('<</Type /FontDescriptor');
  $this->_out('/FontName /'.$font['name']);
  $this->_out('/Flags 6');
  $this->_out('/FontBBox [0 0 1000 1000]');
  $this->_out('/ItalicAngle 0');
  $this->_out('/Ascent 1000');
  $this->_out('/Descent 0');
  $this->_out('/CapHeight 1000');
  $this->_out('/StemV 10');
  $this->_out('>>');
  $this->_out('endobj');
}
}
?>
