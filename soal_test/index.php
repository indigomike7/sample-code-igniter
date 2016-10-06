<!DOCTYPE html>
<html>
<head>
<title>
Hasil Soal Test Michael Butarbutar
</title>
<script type="text/javascript" src="scripts/shCore.js"></script>
<script type="text/javascript" src="scripts/shBrushJScript.js"></script>
<link type="text/css" rel="stylesheet" href="styles/shCoreDefault.css"/>
<script type="text/javascript">SyntaxHighlighter.all();</script>
</head>
<body>
<img src="mike.jpg" style="float:left; margin-right:5px;">
<span style="float:left; margin-right:5px;" >Name  : Michael Butarbutar<br/>
Phone : +6281293109031<br/>
Email : indigomike7@gmail.com<br/></span>
<div style="clear:left;"></div>
<br/>
<pre class="brush: js;">
function test1(){
   $vars = array(0, 1, 2, 4, 3);
   for ($i = 0; $i < count($vars); $i++) {
       print $vars[$i]."";
   }
   echo "<br/>";
}
</pre>
<br/>
<pre class="brush: js;">
function test2(){
   $flavors = array('vanilla', 'pistachio', 'banana', 'caramel', 'strawberry');
   $favorite = 'banana';
   foreach ($flavors as $key => $flavor) {
       if ($flavor == $favorite) {
           print $key."<br/>";
           break;
       }
   }
}
</pre>
<pre class="brush: js;">
function test3(){
   $stuff = array('shoes', 33, null, false, true);
   $selected = 0;
   foreach ($stuff as $key => $thing) {
       if ($thing == $selected) {
           print $key."<br/>";
           break;
       }
   }
}
</pre>
<pre class="brush: js;">
function test4(){
   $four = 4;
   $five = test4_helper($four);
   print "four: $four ";
   print "five: $five <br/>";
}

function test4_helper($arg){
   $return = ++$arg;
   return $return;
}
</pre>
<pre class="brush: js;">
function test5(){
	$a=array();
   $total= 0;
   $tax = 1.2;
   $products = array(
       'Trek Fuel EX 8' => array('price' => 2000, 'quantity' => 1),
       'Trek Remedy 9' => array('price' => 2600, 'quantity' => 2),
       'Trek Scratch 8' => array('price' => 3500, 'quantity' => 1)
   );
	foreach($products as $key=>$value)
	{
			$total=$total+(($value['price']*$tax)*$value['quantity']);
	}
	echo $total;
}
</pre>
Result :<br/>
<?php
function test1(){
   $vars = array(0, 1, 2, 4, 3);
   for ($i = 0; $i < count($vars); $i++) {
       print $vars[$i]."";
   }
   echo "<br/>";
}
?>
<?php
function test2(){
   $flavors = array('vanilla', 'pistachio', 'banana', 'caramel', 'strawberry');
   $favorite = 'banana';
   foreach ($flavors as $key => $flavor) {
       if ($flavor == $favorite) {
           print $key."<br/>";
           break;
       }
   }
}
?>
<?php
function test3(){
   $stuff = array('shoes', 33, null, false, true);
   $selected = 0;
   foreach ($stuff as $key => $thing) {
       if ($thing == $selected) {
           print $key."<br/>";
           break;
       }
   }
}
?>
<?php
function test4(){
   $four = 4;
   $five = test4_helper($four);
   print "four: $four ";
   print "five: $five <br/>";
}

function test4_helper($arg){
   $return = ++$arg;
   return $return;
}
?>
<?php
function test5(){
	$a=array();
   $total= 0;
   $tax = 1.2;
   $products = array(
       'Trek Fuel EX 8' => array('price' => 2000, 'quantity' => 1),
       'Trek Remedy 9' => array('price' => 2600, 'quantity' => 2),
       'Trek Scratch 8' => array('price' => 3500, 'quantity' => 1)
   );
	foreach($products as $key=>$value)
	{
			$total=$total+(($value['price']*$tax)*$value['quantity']);
	}
	echo $total;
}
echo "1 : ";
test1();
echo "2 : ";
test2();
echo "3 : ";
test3();
echo "4 : ";
test4();
echo "5 : ";
test5();
?>
</body>
</html>