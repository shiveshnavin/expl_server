<?php

include 'header.php';

?>
<div id='cssmenu'>
<ul>
   <li ><a href='index.php'>Home</a></li>
   <li class='active'><a href='places.php'>Places</a></li>
   <li><a href='guides.php'>Guides</a></li>
   <li><a href='tours.php'>Tours</a></li>
   <li><a href='users.php'>Users</a></li>
</ul>
</div>
  <section>
<a href="add_place.php" class="button button-alt">ADD PLACE</a>
<a href="places.php" class="button button-alt">REFRESH</a>
  <!--for demo wrap-->
  <title>Places</title> 

  <h1>Places</h1>
  <div class="tbl-header">
    <table cellpadding="0" cellspacing="0" border="0">
      <thead>
        <tr> 
          <th>Name</th>
          <th>Description</th>
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
        $result =  ("DELETE FROM places WHERE id = '".$del_id."' ");
        execute($result);
        alert("Deleted !");

      }


        foreach ( getplaces() as $key => $place) {
 
        

      ?>
        <tr>
          <td><?php echo $place["name"];?></td>
          <td><?php echo $place["desc"];?></td>
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
<a href="add_place.php?id=<?php echo $place['id'];?>" class="button button-alt">UPDATE</a>
<br>
<a href="places.php?del_id=<?php echo $place['id'];?>" class="button button-alt">DELETE</a>

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