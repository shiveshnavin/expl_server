<?php

include 'header.php';

?>
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
<a href="add_guide.php" class="button button-alt">ADD GUIDE</a>
<a href="guides.php" class="button button-alt">REFRESH</a>
  <!--for demo wrap-->
  <title>Guides</title> 

  <h1>Guides</h1>
  <div class="tbl-header">
    <table cellpadding="0" cellspacing="0" border="0">
      <thead>
        <tr> 
          <th>Name</th>
          <th>Description</th>
          <th>Rate/Hour</th>
          <th>Lat/LNG</th>
          <th>Address</th>
          <th>Images</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>
  </div>
  <div class="tbl-content">
    <table cellpadding="0" cellspacing="0" border="0">
      <tbody>
      <?php 


      if(isset($_GET["del_id"])){

        $del_id=$_GET["del_id"]; 
        $result =  ("DELETE FROM guides WHERE id = '".$del_id."' ");
        execute($result);
        alert("Deleted !");

      }


        foreach ( getguides() as $key => $place) {
 
        

      ?>
        <tr>
          <td><?php echo $place["name"];?></td>
          <td><?php echo $place["desc"];?></td>
          <td><?php echo $place["rate"];?></td>
          <td><?php echo $place["lat"].",<br>".$place["lng"];?></td>
          <td><?php echo $place["address"];?></td>
          <td><?php
        //  echo $place["images"];
          $imgs=json_decode($place["images"]);
                foreach ($imgs as $key => $value) {
                  # code...
                  echo '<a href="'.$value.'">IMAGE<br><br></a>';
                }

          ?></td>
          <td>
<a href="add_guide.php?id=<?php echo $place['id'];?>" class="button button-alt">UPDATE</a> 
<a href="guides.php?del_id=<?php echo $place['id'];?>" class="button button-alt">DELETE</a>

</td>

        </tr>


    <?php }  ?>   
      </tbody>
    </table>
  </div>


</section>
<?php

include 'footer.php';

?>