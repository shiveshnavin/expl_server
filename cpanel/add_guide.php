<?php

include 'header.php';

    error_reporting($GLOBALS["error"]);
 
if(isset($_POST["name"])&&isset($_POST["name"])&&isset($_POST["name"]))
{

//var_dump($_POST);
$r=uploadfile($_POST); 
if(isset($r["link"]))
{
	$_POST["image"]=$r["link"];
}

guide($_POST);


}
?>

  <title>Add Guide</title> 

<link rel="stylesheet" href="add_place_files/formoid1/formoid-solid-green.css" type="text/css" />
<script type="text/javascript" src="add_place_files/formoid1/jquery.min.js"></script>
<div id='cssmenu'>
<ul>
  
   <li ><a href='index.php'>Home</a></li>
   <li ><a href='places.php'>Places</a></li>
   <li class='active'><a href='guides.php'>Guides</a></li>
   <li><a href='tours.php'>Tours</a></li>
   <li><a href='users.php'>Users</a></li>
   
</ul>
</div>
  <section>


  <link rel="stylesheet" href="add_place_files/formoid1/formoid-solid-green.css" type="text/css" />
    <script type="text/javascript" src="add_place_files/formoid1/jquery.min.js"></script>
    <form action="" enctype="multipart/form-data" class="formoid-solid-green" style="background-color:#FFFFFF;font-size:14px;font-family:'Roboto',Arial,Helvetica,sans-serif;color:#34495E;max-width:480px;min-width:150px" method="post">
        <div class="title">
            <h2>
<a href="guides.php" class="button button-alt"><h4>BACK</h4></a>
Add A Place
            </h2>
            </div>
        <div class="element-input">
            <label class="title"><span class="required">*</span></label>
            <div class="item-cont">
                <input class="large" type="text" name="name" id="name" required="required" placeholder="Input Text" /><span class="icon-place"></span></div>
       
 
        </div>


        <div class="element-number">
            <label class="title"><span class="required">*</span></label>
            <div class="item-cont">
                <input class="large" type="text"  id="rate" name="rate" required="required" placeholder="Price Rate/Hour" value="" /><span class="icon-place"></span></div>
 <br>*
		<div class="element-select">
		   <label class="title" class="required"> <h3>Select Place </h3> <br> </label>
		   <div class="item-cont">
		      <div class="large">
		         <span>
		        
		            <select name="place_id" required="required" >


		            <?php 

			        foreach ( getplaces() as $key => $place) {

			        	?>


					   <option value="<?php echo $place["id"] ;?>">
					   <?php echo $place["name"] ;?>
					   </option> 

			        	<?php
			        }
			  		
			  		?>		   
		            </select>
		            <i></i><span class="icon-place"></span>
		         </span>
		      </div>
		   </div>
		</div><br>
		

        <div class="element-number">
            <label class="title"><span class="required">*</span></label>
            <div class="item-cont">
                <input class="large" type="text" min="0" max="360" name="lat" id="lat"  required="required" placeholder="Latitude" value="" /><span class="icon-place"></span></div>
        </div>
        <div class="element-number">
            <label class="title"><span class="required">*</span></label>
            <div class="item-cont">
                <input class="large" type="text" min="0" max="360" id="lng" name="lng" required="required" placeholder="Longitude" value="" /><span class="icon-place"></span></div>
        </div>
        <div class="element-textarea">
            <label class="title"><span class="required">*</span></label>
            <div class="item-cont">
                <textarea class="medium"  id="address"  name="address" cols="20" rows="5" required="required" placeholder="Address"></textarea><span class="icon-place"></span></div>
        </div>
        <div class="element-textarea">
            <label class="title"></label>
            <div class="item-cont">
                <textarea class="medium" name="desc"  id="desc" cols="20" rows="5" placeholder="Description"></textarea><span class="icon-place"></span></div>
        </div>

         <div class="element-textarea">
            <label class="title" for="rating">Rating</label>
               
                <select id="rating" name="rating">      
         
                             
          <option value="1">1</option> 
          <option value="2">2</option> 
          <option value="3">3</option> 
          <option value="4">4</option> 
          <option value="5">5</option> 

         
                </select>
            </div>




         <script type="text/javascript">
        	
        	$('input').change(function() {
  $(this).next('label').text($(this).val());
})


        </script>


 <br>
        <div class="element-file">
            <label class="title" for="file">Add Image <br> <br></label>
            <div class="item-cont">
                 <input type="file"  name="file" />
            </div>
        </div>
 <br> <br>
        <input  type="hidden"  name="mode" id="mode"  value="add" />
 <td> 

<?php 
if(isset($_GET["id"])){
$place=getguide($_GET["id"]); 
?>

        <input  type="hidden"  name="id" id="id"  value="<?php echo $place->id ;?>" />
<script type="text/javascript">
    
    document.getElementById('name').value='<?php echo $place->name ;?>' ;  
    document.getElementById('desc').value='<?php echo $place->desc;?>' ; 
    document.getElementById('lat').value='<?php echo $place->lat;?>' ; 
    document.getElementById('lng').value='<?php echo $place->lng;?>' ; 
    document.getElementById('rate').value='<?php echo $place->rate;?>' ; 
    document.getElementById('address').value='<?php echo $place->address;?>' ; 
    document.getElementById('mode').value='update' ;     

document.getElementById('rating').getElementsByTagName('option')[<?php echo ($place->rating-1); ?>].selected = 'selected'



</script>
<?php
}
?>




        <div class="submit">
            <input type="submit" value="Submit" />
        </div>
    </form>
    <p class="frmd"><a href="http://formoid.com/v29.php">html form</a> Formoid.com 2.9</p>
    <script type="text/javascript" src="add_place_files/formoid1/formoid-solid-green.js"></script>
    <!-- Stop Formoid form-->


</section>
<?php

include 'footer.php';

?>